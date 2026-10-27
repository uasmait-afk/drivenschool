
<?php
session_start();

require __DIR__ . '/config/db.php';

/* =========================================
   1. Admin protection
========================================= */
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function e($value): string
{
    return htmlspecialchars(
        (string) ($value ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
}

function tableExists(PDO $pdo, string $table): bool
{
    $stmt = $pdo->prepare(
        'SELECT COUNT(*)
         FROM information_schema.tables
         WHERE table_schema = DATABASE()
         AND table_name = :table'
    );

    $stmt->execute(['table' => $table]);

    return (int) $stmt->fetchColumn() > 0;
}

function tableColumns(PDO $pdo, string $table): array
{
    if (!tableExists($pdo, $table)) {
        return [];
    }

    $stmt = $pdo->query("SHOW COLUMNS FROM `$table`");

    return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'Field');
}

function fetchRows(PDO $pdo, string $sql): array
{
    try {
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
        error_log($exception->getMessage());
        return [];
    }
}

/* =========================================
   2. Navigation
========================================= */
$sections = [
    'overview',
    'bookings',
    'students',
    'messages',
    'payments',
    'reports'
];

$section = $_GET['section'] ?? 'overview';

if (!in_array($section, $sections, true)) {
    $section = 'overview';
}

$message = '';
$error = '';

$allowedStatuses = [
    'Pending',
    'Confirmed',
    'Completed',
    'Cancelled'
];

/* =========================================
   3. Update booking status securely
========================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';

    if (
        !is_string($token) ||
        !hash_equals($_SESSION['csrf_token'], $token)
    ) {
        $error = 'Invalid request. Please refresh the page.';
    } else {
        $bookingId = filter_input(
            INPUT_POST,
            'booking_id',
            FILTER_VALIDATE_INT
        );

        $newStatus = $_POST['status'] ?? '';

        if (
            !$bookingId ||
            !in_array($newStatus, $allowedStatuses, true)
        ) {
            $error = 'Invalid booking ID or status.';
        } else {
            try {
                $stmt = $pdo->prepare(
                    'UPDATE bookings
                     SET status = :status
                     WHERE id = :id'
                );

                $stmt->execute([
                    'status' => $newStatus,
                    'id' => $bookingId
                ]);

                $check = $pdo->prepare(
                    'SELECT id, status FROM bookings WHERE id = :id'
                );

                $check->execute(['id' => $bookingId]);
                $updated = $check->fetch(PDO::FETCH_ASSOC);

                if (!$updated) {
                    $error = 'Booking record not found.';
                } elseif ($updated['status'] === $newStatus) {
                    $message = 'Booking status saved successfully.';
                } else {
                    $error = 'Booking status could not be updated.';
                }
            } catch (PDOException $exception) {
                error_log($exception->getMessage());
                $error = 'Could not update booking status.';
            }
        }
    }

    if ($error !== '') {
        $section = 'bookings';
    }

    if ($message !== '') {
        header('Location: admin.php?section=bookings&updated=1');
        exit;
    }
}

if (isset($_GET['updated'])) {
    $message = 'Booking status updated successfully.';
}

/* =========================================
   4. Load existing tables
========================================= */
$bookings = fetchRows(
    $pdo,
    'SELECT id, full_name, email, phone,
            lesson_type, package_name,
            booking_date, booking_time,
            status, created_at
     FROM bookings
     ORDER BY created_at DESC'
);

$totalBookings = count($bookings);
$pendingCount = 0;
$confirmedCount = 0;
$completedCount = 0;
$cancelledCount = 0;

foreach ($bookings as $booking) {
    switch (strtolower((string) $booking['status'])) {
        case 'pending':
            $pendingCount++;
            break;
        case 'confirmed':
            $confirmedCount++;
            break;
        case 'completed':
            $completedCount++;
            break;
        case 'cancelled':
            $cancelledCount++;
            break;
    }
}

/* =========================================
   5. Students (optional table)
========================================= */
$students = [];
$studentCount = 0;

if (tableExists($pdo, 'students')) {
    $studentColumns = tableColumns($pdo, 'students');

    $studentFields = array_values(array_intersect(
        ['id', 'full_name', 'email', 'phone', 'created_at'],
        $studentColumns
    ));

    if ($studentFields) {
        $studentSql = 'SELECT ' .
            implode(', ', array_map(
                fn($field) => "`$field`",
                $studentFields
            )) .
            ' FROM students ORDER BY id DESC';

        $students = fetchRows($pdo, $studentSql);
        $studentCount = count($students);
    }
}

/* =========================================
   6. Contact messages (optional tables)
========================================= */
$contactTable = null;

foreach ([
    'contact_messages',
    'messages',
    'contacts',
    'contact_submissions'
] as $candidate) {
    if (tableExists($pdo, $candidate)) {
        $contactTable = $candidate;
        break;
    }
}

$contactColumns = $contactTable
    ? tableColumns($pdo, $contactTable)
    : [];

$messages = [];

if ($contactTable && in_array('id', $contactColumns, true)) {
    $safeTable = $contactTable;

    $messages = fetchRows(
        $pdo,
        "SELECT * FROM `$safeTable` ORDER BY id DESC LIMIT 200"
    );
}

/* =========================================
   7. Payments (optional table)
========================================= */
$payments = [];
$paymentColumns = [];

if (tableExists($pdo, 'payments')) {
    $paymentColumns = tableColumns($pdo, 'payments');

    if ($paymentColumns) {
        $payments = fetchRows(
            $pdo,
            'SELECT * FROM payments ORDER BY id DESC LIMIT 200'
        );
    }
}

$paymentCount = count($payments);
$paidCount = 0;
$paidTotal = 0;

foreach ($payments as $payment) {
    $status = strtolower((string) ($payment['status'] ?? ''));

    if (in_array($status, ['paid', 'completed', 'succeeded'], true)) {
        $paidCount++;

        if (isset($payment['amount_cents'])) {
            $paidTotal += (float) $payment['amount_cents'] / 100;
        } elseif (isset($payment['amount'])) {
            $paidTotal += (float) $payment['amount'];
        }
    }
}

/* =========================================
   8. Navigation helper
========================================= */
function navLink(string $key, string $label, string $icon, string $current): string
{
    $active = $key === $current ? 'active' : '';

    return '<a class="side-link ' . $active .
        '" href="admin.php?section=' . e($key) . '">' .
        '<i class="bi ' . e($icon) . '"></i>' .
        '<span>' . e($label) . '</span></a>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Dashboard | DriveN School</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        :root {
            --navy: #101d35;
            --deep: #091426;
            --gold: #f5a623;
            --gold-hover: #ffbb4c;
            --bg: #f4f7fc;
            --text: #26354d;
            --muted: #758198;
            --border: #e5eaf2;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .topbar {
            background: linear-gradient(110deg, var(--deep), var(--navy));
            border-bottom: 3px solid var(--gold);
            color: white;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .brand {
            color: white;
            text-decoration: none;
            font-size: 23px;
            font-weight: 800;
        }

        .brand-mark {
            display: inline-grid;
            place-items: center;
            background: var(--gold);
            color: var(--navy);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            margin-right: 9px;
        }

        .brand span:last-child { color: var(--gold); }

        .gold-btn {
            background: var(--gold);
            color: var(--navy);
            border: 0;
            border-radius: 8px;
            padding: 10px 14px;
            font-weight: 700;
            text-decoration: none;
        }

        .gold-btn:hover { background: var(--gold-hover); color: var(--navy); }

        .layout {
            display: grid;
            grid-template-columns: 245px minmax(0, 1fr);
            min-height: calc(100vh - 75px);
        }

        .sidebar {
            background: var(--navy);
            padding: 25px 14px;
        }

        .side-label {
            color: #9caac0;
            padding: 8px 13px 13px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .side-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #d5ddec;
            padding: 13px 14px;
            margin-bottom: 6px;
            text-decoration: none;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
        }

        .side-link i { font-size: 18px; }

        .side-link:hover,
        .side-link.active {
            background: rgba(245,166,35,.14);
            color: var(--gold);
        }

        .content {
            min-width: 0;
            padding: 32px;
        }

        .eyebrow {
            color: #a66d0c;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .page-title {
            color: var(--navy);
            font-weight: 800;
            margin: 7px 0;
        }

        .muted { color: var(--muted); }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 16px;
            margin: 25px 0;
        }

        .stat-card, .panel {
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(16,29,53,.04);
        }

        .stat-card { padding: 20px; }

        .stat-icon {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            background: #fff3dc;
            color: #9a650e;
            border-radius: 12px;
            font-size: 20px;
            margin-bottom: 18px;
        }

        .stat-label { color: var(--muted); font-size: 13px; }
        .stat-number { color: var(--navy); font-size: 30px; font-weight: 800; }

        .panel { overflow: hidden; margin-bottom: 24px; }

        .panel-head {
            padding: 21px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .panel-head h2 {
            font-size: 18px;
            font-weight: 800;
            color: var(--navy);
            margin: 0;
        }

        .table-responsive { padding: 0 18px 12px; }

        .table { margin: 0; vertical-align: middle; }

        .table th {
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .6px;
            white-space: nowrap;
        }

        .table td, .table th {
            padding: 15px 12px;
            border-color: #edf0f6;
            font-size: 13px;
        }

        .table td { overflow-wrap: anywhere; }

        .form-select { min-width: 125px; font-size: 12px; }

        .update-btn {
            background: var(--navy);
            color: white;
            border: 0;
            border-radius: 7px;
            padding: 8px 10px;
            font-size: 12px;
            font-weight: 700;
        }

        .update-btn:hover { background: #2878f0; }

        .status {
            display: inline-block;
            border-radius: 30px;
            padding: 6px 10px;
            background: #fff3dc;
            color: #8b5c0a;
            font-weight: 700;
            font-size: 11px;
        }

        .empty {
            padding: 45px 20px;
            text-align: center;
            color: var(--muted);
        }

        .empty i {
            font-size: 35px;
            display: block;
            margin-bottom: 12px;
            color: var(--gold);
        }

        .quick-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 25px;
        }

        .quick-link {
            display: block;
            padding: 20px;
            background: white;
            color: var(--navy);
            border: 1px solid var(--border);
            border-radius: 13px;
            text-decoration: none;
            font-weight: 800;
        }

        .quick-link i {
            color: #b77812;
            font-size: 22px;
            display: block;
            margin-bottom: 12px;
        }

        .quick-link:hover { border-color: var(--gold); }

        .report-bar {
            height: 10px;
            background: #edf0f6;
            border-radius: 20px;
            overflow: hidden;
            margin: 8px 0 18px;
        }

        .report-fill {
            height: 100%;
            background: var(--gold);
            border-radius: 20px;
        }

        .footer {
            padding: 20px;
            color: var(--muted);
            text-align: center;
            font-size: 12px;
        }

        @media (max-width: 1100px) {
            .stat-grid { grid-template-columns: repeat(3, minmax(0,1fr)); }
            .quick-grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
        }

        @media (max-width: 760px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar { padding: 12px; }
            .sidebar nav { display: flex; flex-wrap: wrap; gap: 5px; }
            .side-label { width: 100%; }
            .side-link { margin: 0; padding: 10px; }
            .content { padding: 20px 13px; }
            .stat-grid { grid-template-columns: repeat(2, minmax(0,1fr)); gap: 10px; }
            .stat-card { padding: 14px; }
            .stat-number { font-size: 25px; }
            .quick-grid { grid-template-columns: 1fr; }
            .topbar { padding: 13px; }
            .brand { font-size: 18px; }
        }
    </style>
</head>

<body>

<header class="topbar">
    <a class="brand" href="admin.php">
        <span class="brand-mark">D</span>
        Drive<span>N</span> School
    </a>

    <div class="d-flex gap-2 flex-wrap">
        <a href="index.php" class="btn btn-outline-light btn-sm">
            <i class="bi bi-globe me-1"></i> Website
        </a>

        <form action="logout.php" method="POST" class="m-0">
            <input type="hidden" name="csrf_token"
                   value="<?= e($_SESSION['csrf_token']) ?>">
            <button class="gold-btn" type="submit">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>
</header>

<div class="layout">

    <aside class="sidebar">
        <div class="side-label">ADMIN MENU</div>

        <nav>
            <?= navLink('overview', 'Overview', 'bi-grid-1x2', $section) ?>
            <?= navLink('bookings', 'Bookings', 'bi-calendar2-check', $section) ?>
            <?= navLink('students', 'Students', 'bi-people', $section) ?>
            <?= navLink('messages', 'Messages', 'bi-envelope', $section) ?>
            <?= navLink('payments', 'Payments', 'bi-credit-card', $section) ?>
            <?= navLink('reports', 'Reports', 'bi-bar-chart', $section) ?>
        </nav>
    </aside>

    <main class="content">

        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
            <div>
                <div class="eyebrow">DRIVEN SCHOOL MANAGEMENT</div>

                <h1 class="page-title">
                    <?php
                    $titles = [
                        'overview' => 'Dashboard Overview',
                        'bookings' => 'Booking Management',
                        'students' => 'Student Directory',
                        'messages' => 'Contact Messages',
                        'payments' => 'Payment Records',
                        'reports' => 'Reports & Analytics'
                    ];
                    echo e($titles[$section]);
                    ?>
                </h1>

                <p class="muted mb-0">
                    Manage your driving school from one place.
                </p>
            </div>

            <div class="muted small">
                <i class="bi bi-calendar3 me-1"></i>
                <?= date('F j, Y') ?>
            </div>
        </div>

        <?php if ($message !== ''): ?>
            <div class="alert alert-success"><?= e($message) ?></div>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>

        <?php if ($section === 'overview'): ?>

            <section class="stat-grid">
                <?php
                $stats = [
                    ['Total Bookings', $totalBookings, 'bi-calendar2-week'],
                    ['Pending', $pendingCount, 'bi-hourglass-split'],
                    ['Confirmed', $confirmedCount, 'bi-calendar-check'],
                    ['Completed', $completedCount, 'bi-check-circle'],
                    ['Cancelled', $cancelledCount, 'bi-calendar-x']
                ];
                ?>

                <?php foreach ($stats as $stat): ?>
                    <article class="stat-card">
                        <div class="stat-icon">
                            <i class="bi <?= e($stat[2]) ?>"></i>
                        </div>
                        <div class="stat-label"><?= e($stat[0]) ?></div>
                        <div class="stat-number"><?= (int) $stat[1] ?></div>
                    </article>
                <?php endforeach; ?>
            </section>

            <section class="quick-grid">
                <a class="quick-link" href="admin.php?section=bookings">
                    <i class="bi bi-calendar2-check"></i>
                    Manage Bookings
                    <div class="muted small mt-2">
                        Review and update appointment status.
                    </div>
                </a>

                <a class="quick-link" href="admin.php?section=students">
                    <i class="bi bi-people"></i>
                    Student Directory
                    <div class="muted small mt-2">
                        View registered student accounts.
                    </div>
                </a>

                <a class="quick-link" href="admin.php?section=messages">
                    <i class="bi bi-envelope"></i>
                    Contact Messages
                    <div class="muted small mt-2">
                        Review customer inquiries.
                    </div>
                </a>

                <a class="quick-link" href="admin.php?section=payments">
                    <i class="bi bi-credit-card"></i>
                    Payment Records
                    <div class="muted small mt-2">
                        Review available payment records.
                    </div>
                </a>

                <a class="quick-link" href="admin.php?section=reports">
                    <i class="bi bi-bar-chart"></i>
                    Reports
                    <div class="muted small mt-2">
                        See booking and payment summaries.
                    </div>
                </a>
            </section>

        <?php endif; ?>

        <?php if ($section === 'bookings'): ?>

            <section class="panel">
                <div class="panel-head">
                    <div>
                        <h2><i class="bi bi-calendar2-check me-2"></i>All Bookings</h2>
                        <div class="muted small mt-1">
                            Change the status and press Update.
                        </div>
                    </div>
                    <span class="status"><?= $totalBookings ?> records</span>
                </div>

                <?php if (!$bookings): ?>
                    <div class="empty">
                        <i class="bi bi-calendar2-x"></i>
                        No bookings found.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID / Customer</th>
                                <th>Lesson / Package</th>
                                <th>Appointment</th>
                                <th>Status</th>
                                <th>Update</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td>
                                        <strong>#<?= (int) $booking['id'] ?>
                                            <?= e($booking['full_name']) ?></strong>
                                        <div class="muted mt-1"><?= e($booking['email']) ?></div>
                                        <div class="muted"><?= e($booking['phone']) ?></div>
                                    </td>
                                    <td>
                                        <strong><?= e($booking['lesson_type']) ?></strong>
                                        <div class="muted mt-1"><?= e($booking['package_name']) ?></div>
                                    </td>
                                    <td>
                                        <?= e($booking['booking_date']) ?>
                                        <div class="muted mt-1"><?= e($booking['booking_time']) ?></div>
                                    </td>
                                    <td><span class="status"><?= e($booking['status']) ?></span></td>
                                    <td>
                                        <form method="POST" action="admin.php?section=bookings">
                                            <input type="hidden" name="csrf_token"
                                                   value="<?= e($_SESSION['csrf_token']) ?>">
                                            <input type="hidden" name="booking_id"
                                                   value="<?= (int) $booking['id'] ?>">

                                            <select name="status" class="form-select mb-2" required>
                                                <?php foreach ($allowedStatuses as $status): ?>
                                                    <option value="<?= e($status) ?>"
                                                        <?= $booking['status'] === $status ? 'selected' : '' ?>>
                                                        <?= e($status) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>

                                            <button class="update-btn" type="submit">
                                                <i class="bi bi-check2 me-1"></i> Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>

        <?php endif; ?>

        <?php if ($section === 'students'): ?>

            <section class="panel">
                <div class="panel-head">
                    <h2>Registered Students</h2>
                    <span class="status"><?= $studentCount ?> students</span>
                </div>

                <?php if (!$students): ?>
                    <div class="empty">
                        <i class="bi bi-people"></i>
                        No students found, or the students table is not available.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <?php foreach (array_keys($students[0]) as $column): ?>
                                    <th><?= e(ucwords(str_replace('_', ' ', $column))) ?></th>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <?php foreach ($student as $value): ?>
                                        <td><?= e($value) ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>

        <?php endif; ?>

        <?php if ($section === 'messages'): ?>

            <section class="panel">
                <div class="panel-head">
                    <h2>Contact Messages</h2>
                    <span class="status"><?= count($messages) ?> records</span>
                </div>

                <?php if (!$contactTable || !$messages): ?>
                    <div class="empty">
                        <i class="bi bi-envelope-open"></i>
                        No messages found, or the contact table name differs.
                        <div class="small mt-2">
                            Detected table:
                            <?= e($contactTable ?? 'None') ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <?php foreach (array_keys($messages[0]) as $column): ?>
                                    <th><?= e(ucwords(str_replace('_', ' ', $column))) ?></th>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($messages as $row): ?>
                                <tr>
                                    <?php foreach ($row as $column => $value): ?>
                                        <td>
                                            <?php
                                            if (stripos((string) $column, 'message') !== false ||
                                                stripos((string) $column, 'body') !== false) {
                                                echo nl2br(e($value));
                                            } else {
                                                echo e($value);
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>

        <?php endif; ?>

        <?php if ($section === 'payments'): ?>

            <section class="stat-grid" style="grid-template-columns:repeat(auto-fit,minmax(170px,1fr))">
                <article class="stat-card">
                    <div class="stat-label">Payment Records</div>
                    <div class="stat-number"><?= $paymentCount ?></div>
                </article>
                <article class="stat-card">
                    <div class="stat-label">Successful Records</div>
                    <div class="stat-number"><?= $paidCount ?></div>
                </article>
                <article class="stat-card">
                    <div class="stat-label">Recorded Amount</div>
                    <div class="stat-number" style="font-size:25px">
                        $<?= number_format($paidTotal, 2) ?>
                    </div>
                    <div class="muted small">Based on recognized amount columns.</div>
                </article>
            </section>

            <section class="panel">
                <div class="panel-head">
                    <h2>Payment Records</h2>
                    <span class="status"><?= $paymentCount ?> records</span>
                </div>

                <?php if (!$payments): ?>
                    <div class="empty">
                        <i class="bi bi-credit-card"></i>
                        No payment records available yet.
                        <div class="small mt-2">
                            This page does not create or verify payments.
                        </div>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <?php foreach (array_keys($payments[0]) as $column): ?>
                                    <th><?= e(ucwords(str_replace('_', ' ', $column))) ?></th>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($payments as $payment): ?>
                                <tr>
                                    <?php foreach ($payment as $value): ?>
                                        <td><?= e($value) ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>

        <?php endif; ?>

        <?php if ($section === 'reports'): ?>

            <section class="stat-grid">
                <article class="stat-card">
                    <div class="stat-label">Total Bookings</div>
                    <div class="stat-number"><?= $totalBookings ?></div>
                </article>
                <article class="stat-card">
                    <div class="stat-label">Registered Students</div>
                    <div class="stat-number"><?= $studentCount ?></div>
                </article>
                <article class="stat-card">
                    <div class="stat-label">Successful Payment Records</div>
                    <div class="stat-number"><?= $paidCount ?></div>
                </article>
            </section>

            <section class="panel">
                <div class="panel-head">
                    <h2>Booking Status Report</h2>
                </div>

                <div class="p-4">
                    <?php
                    $reportStatuses = [
                        ['Pending', $pendingCount],
                        ['Confirmed', $confirmedCount],
                        ['Completed', $completedCount],
                        ['Cancelled', $cancelledCount]
                    ];
                    ?>

                    <?php foreach ($reportStatuses as [$label, $count]): ?>
                        <div class="d-flex justify-content-between gap-3">
                            <span><?= e($label) ?></span>
                            <strong><?= (int) $count ?></strong>
                        </div>

                        <div class="report-bar">
                            <div class="report-fill"
                                 style="width:<?= $totalBookings > 0
                                     ? min(100, ($count / $totalBookings) * 100)
                                     : 0 ?>%">
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Successful payment records total</span>
                        <strong>$<?= number_format($paidTotal, 2) ?></strong>
                    </div>

                    <p class="muted small mt-3 mb-0">
                        This is a summary of records currently stored in the database,
                        not a verified accounting statement.
                    </p>
                </div>
            </section>

        <?php endif; ?>

        <footer class="footer">
            &copy; <?= date('Y') ?> DriveN School · Admin Management
        </footer>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
