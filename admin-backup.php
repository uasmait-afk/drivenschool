
<?php
session_start();

require __DIR__ . '/config/db.php';

/* =====================================
   1. Admin Login Protection
===================================== */
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

/* =====================================
   2. CSRF Token
===================================== */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$allowedStatuses = [
    'Pending',
    'Confirmed',
    'Completed',
    'Cancelled'
];

$message = '';
$error = '';

/* =====================================
   3. Update Booking Status
===================================== */
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

                if ($stmt->rowCount() > 0) {
                    $message = 'Booking status updated successfully!';
                } else {
                    $check = $pdo->prepare(
                        'SELECT id, status
                         FROM bookings
                         WHERE id = :id'
                    );

                    $check->execute(['id' => $bookingId]);
                    $existing = $check->fetch(PDO::FETCH_ASSOC);

                    if (!$existing) {
                        $error = 'Booking record not found.';
                    } elseif ($existing['status'] === $newStatus) {
                        $message = 'Booking already has this status.';
                    } else {
                        $error = 'Booking status could not be updated.';
                    }
                }

            } catch (PDOException $e) {
                error_log($e->getMessage());
                $error = 'Could not update booking status.';
            }
        }
    }
}

/* =====================================
   4. Fetch All Bookings
===================================== */
try {
    $stmt = $pdo->query(
        'SELECT id, full_name, email, phone,
                lesson_type, package_name,
                booking_date, booking_time,
                status, created_at
         FROM bookings
         ORDER BY created_at DESC'
    );

    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log($e->getMessage());
    $bookings = [];
    $error = 'Could not load bookings. Check your database table.';
}

/* =====================================
   5. Helper Function
===================================== */
function e($value): string
{
    return htmlspecialchars(
        (string) ($value ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
}

/* =====================================
   6. Dashboard Statistics
===================================== */
$totalBookings = count($bookings);

$pendingCount = 0;
$confirmedCount = 0;
$completedCount = 0;
$cancelledCount = 0;

foreach ($bookings as $booking) {
    switch ($booking['status']) {
        case 'Pending':
            $pendingCount++;
            break;

        case 'Confirmed':
            $confirmedCount++;
            break;

        case 'Completed':
            $completedCount++;
            break;

        case 'Cancelled':
            $cancelledCount++;
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard | DriveN School</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <!-- Existing Website CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        :root {
            --admin-navy: #101d35;
            --admin-deep: #091426;
            --admin-blue: #2878f0;
            --admin-gold: #f5a623;
            --admin-gold-hover: #ffbb4c;
            --admin-bg: #f4f7fc;
            --admin-text: #26354d;
            --admin-muted: #758198;
            --admin-border: #e5eaf2;
            --admin-white: #ffffff;
        }

        body.admin-page {
            margin: 0;
            padding: 0;
            background: var(--admin-bg);
            color: var(--admin-text);
            font-family: "DM Sans", Arial, sans-serif;
            min-height: 100vh;
        }

        .admin-page *,
        .admin-page *::before,
        .admin-page *::after {
            box-sizing: border-box;
        }

        .admin-header {
            background: var(--admin-navy);
            color: white;
            padding: 17px 0;
            box-shadow: 0 5px 25px rgba(9, 20, 38, 0.12);
        }

        .admin-header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            color: white;
            text-decoration: none;
            font-size: 23px;
            font-weight: 800;
        }

        .admin-brand:hover {
            color: white;
        }

        .admin-brand-mark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 11px;
            background: var(--admin-gold);
            color: var(--admin-navy);
            font-size: 25px;
            font-weight: 900;
        }

        .admin-brand span:last-child {
            color: var(--admin-gold);
        }

        .admin-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: 0.2s ease;
            cursor: pointer;
        }

        .admin-btn-outline {
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            background: transparent;
        }

        .admin-btn-outline:hover {
            color: var(--admin-gold);
            border-color: var(--admin-gold);
        }

        .admin-btn-gold {
            border: 1px solid var(--admin-gold);
            background: var(--admin-gold);
            color: var(--admin-navy);
        }

        .admin-btn-gold:hover {
            background: var(--admin-gold-hover);
            border-color: var(--admin-gold-hover);
            color: var(--admin-navy);
        }

        .admin-main {
            width: 100%;
            max-width: 1440px;
            margin: 0 auto;
            padding: 36px 24px 50px;
        }

        .admin-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 27px;
        }

        .admin-eyebrow {
            margin-bottom: 8px;
            color: #b77812;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .admin-title {
            margin: 0 0 8px;
            color: var(--admin-navy);
            font-size: clamp(27px, 4vw, 36px);
            font-weight: 800;
            letter-spacing: -1px;
        }

        .admin-subtitle {
            margin: 0;
            color: var(--admin-muted);
            font-size: 14px;
        }

        .admin-date {
            color: var(--admin-muted);
            font-size: 13px;
            white-space: nowrap;
        }

        .admin-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 15px 17px;
            margin-bottom: 22px;
            border-radius: 10px;
            font-size: 14px;
        }

        .admin-alert-success {
            background: #e8f8ef;
            border: 1px solid #bce8ce;
            color: #176b3b;
        }

        .admin-alert-error {
            background: #fff0f0;
            border: 1px solid #f4c7c7;
            color: #a12626;
        }

        .admin-stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .admin-stat {
            position: relative;
            overflow: hidden;
            padding: 22px;
            background: var(--admin-white);
            border: 1px solid var(--admin-border);
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(16, 29, 53, 0.035);
        }

        .admin-stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 20px;
        }

        .admin-stat-label {
            color: var(--admin-muted);
            font-size: 13px;
            font-weight: 700;
        }

        .admin-stat-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 12px;
            font-size: 19px;
        }

        .stat-total .admin-stat-icon {
            background: #e8efff;
            color: #2865d8;
        }

        .stat-pending .admin-stat-icon {
            background: #fff3dc;
            color: #b77812;
        }

        .stat-confirmed .admin-stat-icon {
            background: #e4f7ed;
            color: #16834c;
        }

        .stat-completed .admin-stat-icon {
            background: #e5f4ff;
            color: #1670b8;
        }

        .stat-cancelled .admin-stat-icon {
            background: #ffe8e8;
            color: #c13b3b;
        }

        .admin-stat-number {
            display: block;
            color: var(--admin-navy);
            font-size: 33px;
            font-weight: 800;
            line-height: 1.1;
        }

        .admin-stat-caption {
            margin-top: 7px;
            color: var(--admin-muted);
            font-size: 12px;
        }

        .admin-table-card {
            overflow: hidden;
            background: var(--admin-white);
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            box-shadow: 0 7px 30px rgba(16, 29, 53, 0.045);
        }

        .admin-table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 22px 24px;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-table-title {
            margin: 0;
            color: var(--admin-navy);
            font-size: 18px;
            font-weight: 800;
        }

        .admin-table-description {
            margin: 5px 0 0;
            color: var(--admin-muted);
            font-size: 12px;
        }

        .admin-count {
            padding: 7px 11px;
            border-radius: 8px;
            background: #fff3dc;
            color: #95600d;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .admin-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            min-width: 1050px;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .admin-table thead th {
            padding: 15px 18px;
            background: #f8faff;
            border-bottom: 1px solid var(--admin-border);
            color: #758198;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .admin-table tbody td {
            padding: 19px 18px;
            border-bottom: 1px solid #edf0f6;
            color: var(--admin-text);
            font-size: 13px;
            vertical-align: middle;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        .admin-table tbody tr:hover td {
            background: #fbfcff;
        }

        .customer-name {
            margin-bottom: 5px;
            color: var(--admin-navy);
            font-weight: 800;
        }

        .customer-detail {
            margin-top: 4px;
            color: var(--admin-muted);
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .lesson-name {
            color: var(--admin-navy);
            font-weight: 700;
        }

        .package-name {
            margin-top: 5px;
            color: var(--admin-muted);
            font-size: 12px;
        }

        .appointment-date {
            color: var(--admin-navy);
            font-weight: 700;
            white-space: nowrap;
        }

        .appointment-time {
            margin-top: 5px;
            color: var(--admin-muted);
            font-size: 12px;
            white-space: nowrap;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-pending {
            background: #fff3dc;
            color: #95600d;
        }

        .status-confirmed {
            background: #e3f7eb;
            color: #197444;
        }

        .status-completed {
            background: #e5f3ff;
            color: #1766a6;
        }

        .status-cancelled {
            background: #ffe8e8;
            color: #b72f2f;
        }

        .status-form {
            display: flex;
            align-items: center;
            gap: 7px;
            min-width: 220px;
        }

        .status-select {
            width: 135px;
            min-height: 37px;
            padding: 7px 9px;
            border: 1px solid #dce3ef;
            border-radius: 7px;
            background: white;
            color: var(--admin-text);
            font-size: 12px;
        }

        .status-select:focus {
            border-color: var(--admin-blue);
            outline: 3px solid rgba(40, 120, 240, 0.12);
        }

        .status-update-btn {
            min-height: 37px;
            padding: 7px 10px;
            border: 0;
            border-radius: 7px;
            background: var(--admin-navy);
            color: white;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .status-update-btn:hover {
            background: var(--admin-blue);
        }

        .admin-empty {
            padding: 65px 20px;
            text-align: center;
        }

        .admin-empty-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            margin-bottom: 18px;
            border-radius: 20px;
            background: #eaf0fc;
            color: var(--admin-blue);
            font-size: 30px;
        }

        .admin-empty h3 {
            margin-bottom: 8px;
            color: var(--admin-navy);
            font-size: 19px;
            font-weight: 800;
        }

        .admin-empty p {
            margin: 0;
            color: var(--admin-muted);
            font-size: 14px;
        }

        .admin-footer {
            padding: 25px 15px;
            color: var(--admin-muted);
            font-size: 12px;
            text-align: center;
        }

        @media (max-width: 1199px) {
            .admin-stats {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 767px) {
            .admin-header {
                padding: 14px 0;
            }

            .admin-header-inner {
                align-items: flex-start;
                flex-direction: column;
                gap: 15px;
            }

            .admin-brand {
                font-size: 20px;
            }

            .admin-brand-mark {
                width: 36px;
                height: 36px;
                font-size: 21px;
            }

            .admin-header-actions {
                width: 100%;
                flex-wrap: wrap;
            }

            .admin-main {
                padding: 27px 14px 35px;
            }

            .admin-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 10px;
            }

            .admin-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .admin-stat {
                padding: 16px;
            }

            .admin-stat-top {
                align-items: flex-start;
                margin-bottom: 16px;
            }

            .admin-stat-label {
                font-size: 12px;
            }

            .admin-stat-icon {
                width: 34px;
                height: 34px;
                font-size: 16px;
            }

            .admin-stat-number {
                font-size: 28px;
            }

            .admin-table-header {
                padding: 18px 16px;
            }

            .admin-table-title {
                font-size: 16px;
            }
        }

        @media (max-width: 380px) {
            .admin-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="admin-page">

    <!-- =================================
         Admin Header
    ================================== -->
    <header class="admin-header">
        <div class="container-fluid px-3 px-lg-4">
            <div class="admin-header-inner">

                <a href="admin.php" class="admin-brand">
                    <span class="admin-brand-mark">D</span>
                    <span>Drive<span>N</span> School</span>
                </a>

                <div class="admin-header-actions">

                    <a href="index.php"
                       class="admin-btn admin-btn-outline">
                        <i class="bi bi-globe2"></i>
                        View Website
                    </a>

                    <form action="logout.php"
                          method="POST"
                          class="m-0">

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= e($_SESSION['csrf_token']) ?>"
                        >

                        <button type="submit"
                                class="admin-btn admin-btn-gold">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </header>

    <!-- =================================
         Dashboard Content
    ================================== -->
    <main class="admin-main">

        <section class="admin-heading">

            <div>
                <div class="admin-eyebrow">
                    <i class="bi bi-grid-1x2-fill"></i>
                    Management Center
                </div>

                <h1 class="admin-title">
                    Booking Dashboard
                </h1>

                <p class="admin-subtitle">
                    Manage customer appointments and booking status.
                </p>
            </div>

            <div class="admin-date">
                <i class="bi bi-calendar3 me-1"></i>
                <?= date('F j, Y') ?>
            </div>

        </section>

        <!-- Success Message -->
        <?php if ($message !== ''): ?>
            <div class="admin-alert admin-alert-success" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <div><?= e($message) ?></div>
            </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if ($error !== ''): ?>
            <div class="admin-alert admin-alert-error" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div><?= e($error) ?></div>
            </div>
        <?php endif; ?>

        <!-- =================================
             Statistics Cards
        ================================== -->
        <section class="admin-stats">

            <article class="admin-stat stat-total">
                <div class="admin-stat-top">
                    <span class="admin-stat-label">Total Bookings</span>
                    <span class="admin-stat-icon">
                        <i class="bi bi-calendar2-week"></i>
                    </span>
                </div>

                <strong class="admin-stat-number">
                    <?= $totalBookings ?>
                </strong>

                <div class="admin-stat-caption">
                    All booking records
                </div>
            </article>

            <article class="admin-stat stat-pending">
                <div class="admin-stat-top">
                    <span class="admin-stat-label">Pending</span>
                    <span class="admin-stat-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </span>
                </div>

                <strong class="admin-stat-number">
                    <?= $pendingCount ?>
                </strong>

                <div class="admin-stat-caption">
                    Awaiting confirmation
                </div>
            </article>

            <article class="admin-stat stat-confirmed">
                <div class="admin-stat-top">
                    <span class="admin-stat-label">Confirmed</span>
                    <span class="admin-stat-icon">
                        <i class="bi bi-calendar2-check"></i>
                    </span>
                </div>

                <strong class="admin-stat-number">
                    <?= $confirmedCount ?>
                </strong>

                <div class="admin-stat-caption">
                    Approved bookings
                </div>
            </article>

            <article class="admin-stat stat-completed">
                <div class="admin-stat-top">
                    <span class="admin-stat-label">Completed</span>
                    <span class="admin-stat-icon">
                        <i class="bi bi-check2-circle"></i>
                    </span>
                </div>

                <strong class="admin-stat-number">
                    <?= $completedCount ?>
                </strong>

                <div class="admin-stat-caption">
                    Finished appointments
                </div>
            </article>

            <article class="admin-stat stat-cancelled">
                <div class="admin-stat-top">
                    <span class="admin-stat-label">Cancelled</span>
                    <span class="admin-stat-icon">
                        <i class="bi bi-calendar2-x"></i>
                    </span>
                </div>

                <strong class="admin-stat-number">
                    <?= $cancelledCount ?>
                </strong>

                <div class="admin-stat-caption">
                    Cancelled bookings
                </div>
            </article>

        </section>

        <!-- =================================
             All Bookings Table
        ================================== -->
        <section class="admin-table-card">

            <div class="admin-table-header">
                <div>
                    <h2 class="admin-table-title">
                        <i class="bi bi-list-check me-2"></i>
                        All Bookings
                    </h2>

                    <p class="admin-table-description">
                        Review customer details and update appointment status.
                    </p>
                </div>

                <span class="admin-count">
                    <?= $totalBookings ?>
                    <?= $totalBookings === 1 ? 'Record' : 'Records' ?>
                </span>
            </div>

            <?php if (empty($bookings)): ?>

                <div class="admin-empty">
                    <div class="admin-empty-icon">
                        <i class="bi bi-calendar2-plus"></i>
                    </div>

                    <h3>No Bookings Yet</h3>

                    <p>
                        Customer bookings will appear here when submitted.
                    </p>
                </div>

            <?php else: ?>

                <div class="admin-table-wrapper">

                    <table class="admin-table">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Lesson / Package</th>
                                <th>Appointment</th>
                                <th>Status</th>
                                <th>Update Status</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($bookings as $booking): ?>

                            <?php
                            $statusClass = match ($booking['status']) {
                                'Confirmed' => 'status-confirmed',
                                'Completed' => 'status-completed',
                                'Cancelled' => 'status-cancelled',
                                default => 'status-pending',
                            };

                            $statusIcon = match ($booking['status']) {
                                'Confirmed' => 'bi-check-circle-fill',
                                'Completed' => 'bi-patch-check-fill',
                                'Cancelled' => 'bi-x-circle-fill',
                                default => 'bi-clock-fill',
                            };

                            $dateTimestamp = strtotime(
                                (string) $booking['booking_date']
                            );

                            $displayDate = $dateTimestamp
                                ? date('M d, Y', $dateTimestamp)
                                : e($booking['booking_date']);

                            $timeTimestamp = strtotime(
                                (string) $booking['booking_time']
                            );

                            $displayTime = $timeTimestamp
                                ? date('h:i A', $timeTimestamp)
                                : e($booking['booking_time']);
                            ?>

                            <tr>

                                <td>
                                    <strong>#<?= e($booking['id']) ?></strong>
                                </td>

                                <td>
                                    <div class="customer-name">
                                        <?= e($booking['full_name']) ?>
                                    </div>

                                    <div class="customer-detail">
                                        <i class="bi bi-envelope me-1"></i>
                                        <?= e($booking['email']) ?>
                                    </div>

                                    <div class="customer-detail">
                                        <i class="bi bi-telephone me-1"></i>
                                        <?= e($booking['phone']) ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="lesson-name">
                                        <?= e($booking['lesson_type']) ?>
                                    </div>

                                    <div class="package-name">
                                        <i class="bi bi-box-seam me-1"></i>
                                        <?= e($booking['package_name']) ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="appointment-date">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?= $displayDate ?>
                                    </div>

                                    <div class="appointment-time">
                                        <i class="bi bi-clock me-1"></i>
                                        <?= $displayTime ?>
                                    </div>
                                </td>

                                <td>
                                    <span class="status-pill <?= e($statusClass) ?>">
                                        <i class="bi <?= e($statusIcon) ?>"></i>
                                        <?= e($booking['status']) ?>
                                    </span>
                                </td>

                                <td>
                                    <form action="admin.php"
                                          method="POST"
                                          class="status-form">

                                        <input
                                            type="hidden"
                                            name="csrf_token"
                                            value="<?= e($_SESSION['csrf_token']) ?>"
                                        >

                                        <input
                                            type="hidden"
                                            name="booking_id"
                                            value="<?= e($booking['id']) ?>"
                                        >

                                        <select
                                            name="status"
                                            class="status-select"
                                            aria-label="Select booking status"
                                            required
                                        >

                                            <?php foreach ($allowedStatuses as $status): ?>
                                                <option
                                                    value="<?= e($status) ?>"
                                                    <?= $booking['status'] === $status
                                                        ? 'selected'
                                                        : '' ?>
                                                >
                                                    <?= e($status) ?>
                                                </option>
                                            <?php endforeach; ?>

                                        </select>

                                        <button
                                            type="submit"
                                            class="status-update-btn"
                                        >
                                            <i class="bi bi-arrow-repeat"></i>
                                            Update
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

        <footer class="admin-footer">
            &copy; <?= date('Y') ?> DriveN School.
            Admin Management Dashboard.
        </footer>

    </main>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
