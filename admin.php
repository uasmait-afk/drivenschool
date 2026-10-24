
<?php
session_start();

require __DIR__ . '/config/db.php';

// Protect admin dashboard
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// CSRF protection
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

// Update booking status
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
                        'SELECT id, status FROM bookings WHERE id = :id'
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

// Load bookings
try {
    $stmt = $pdo->query(
        'SELECT id, full_name, email, phone, lesson_type,
                package_name, booking_date, booking_time,
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

// Escape output safely
function e($value): string
{
    return htmlspecialchars(
        (string) ($value ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
}

// Count each status
$totalBookings = count($bookings);

$pendingCount = count(array_filter(
    $bookings,
    fn($b) => $b['status'] === 'Pending'
));

$confirmedCount = count(array_filter(
    $bookings,
    fn($b) => $b['status'] === 'Confirmed'
));

$completedCount = count(array_filter(
    $bookings,
    fn($b) => $b['status'] === 'Completed'
));

$cancelledCount = count(array_filter(
    $bookings,
    fn($b) => $b['status'] === 'Cancelled'
));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Booking Dashboard | DriveN School</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .admin-stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 16px;
        }

        .admin-stat {
            background: #fff;
            padding: 22px;
            border-radius: 14px;
            border: 1px solid #e8edf5;
            box-shadow: 0 5px 18px rgba(20, 37, 68, .05);
        }

        .admin-stat span {
            display: block;
            color: #68758a;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .admin-stat strong {
            display: block;
            color: #142544;
            font-size: 30px;
            line-height: 1.2;
        }

        .stat-pending strong { color: #bd7900; }
        .stat-confirmed strong { color: #198754; }
        .stat-completed strong { color: #2455a4; }
        .stat-cancelled strong { color: #dc3545; }

        .admin-table-card {
            overflow: hidden;
        }

        .admin-table th {
            white-space: nowrap;
        }

        .admin-table td {
            vertical-align: middle;
        }

        .admin-table td small {
            display: block;
            margin-top: 4px;
            color: #6c757d;
        }

        .appointment-date {
            font-weight: 600;
            white-space: nowrap;
        }

        .appointment-time {
            color: #68758a;
            font-size: 13px;
            margin-top: 5px;
            white-space: nowrap;
        }

        .status-pill {
            display: inline-block;
            padding: 7px 11px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-pending {
            background: #fff0ce;
            color: #8a5b00;
        }

        .status-confirmed {
            background: #d9f5e4;
            color: #176b3b;
        }

        .status-completed {
            background: #dce9ff;
            color: #214e9a;
        }

        .status-cancelled {
            background: #ffe1e1;
            color: #a32222;
        }

        .status-form {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 145px;
        }

        .status-form .btn-update {
            width: 100%;
            background: #fdbb2d;
            color: #142544;
            border: 1px solid #fdbb2d;
            font-weight: 700;
        }

        .status-form .btn-update:hover {
            background: #e9a916;
            border-color: #e9a916;
        }

        @media (max-width: 991px) {
            .admin-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575px) {
            .admin-stats {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .admin-stat {
                padding: 16px;
            }

            .admin-stat strong {
                font-size: 25px;
            }

            .admin-heading h1 {
                font-size: 27px;
            }
        }
    </style>
</head>

<body class="admin-page">

<header class="admin-header">
    <div class="container d-flex flex-wrap justify-content-between
                align-items-center gap-3">

        <a href="index.php" class="admin-brand">
            DriveN <span>School</span>
        </a>

        <div class="d-flex align-items-center gap-2">
            <a href="index.php" class="btn btn-outline-light btn-sm">
                <i class="bi bi-globe2"></i> View Website
            </a>

            <form action="logout.php" method="POST" class="d-inline">
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= e($_SESSION['csrf_token']) ?>"
                >

                <button type="submit" class="btn btn-warning btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>
</header>

<main class="container-fluid container-xl py-4 py-md-5">

    <div class="admin-heading mb-4">
        <p class="admin-eyebrow">MANAGEMENT CENTER</p>
        <h1>Booking Dashboard</h1>
        <p>Manage customer appointments and booking status.</p>
    </div>

    <?php if ($message !== ''): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= e($message) ?>
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= e($error) ?>
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="admin-stats mb-4">

        <div class="admin-stat">
            <span><i class="bi bi-calendar-check me-1"></i> Total Bookings</span>
            <strong><?= $totalBookings ?></strong>
        </div>

        <div class="admin-stat stat-pending">
            <span><i class="bi bi-hourglass-split me-1"></i> Pending</span>
            <strong><?= $pendingCount ?></strong>
        </div>

        <div class="admin-stat stat-confirmed">
            <span><i class="bi bi-check-circle me-1"></i> Confirmed</span>
            <strong><?= $confirmedCount ?></strong>
        </div>

        <div class="admin-stat stat-completed">
            <span><i class="bi bi-flag me-1"></i> Completed</span>
            <strong><?= $completedCount ?></strong>
        </div>

        <div class="admin-stat stat-cancelled">
            <span><i class="bi bi-x-circle me-1"></i> Cancelled</span>
            <strong><?= $cancelledCount ?></strong>
        </div>

    </div>

    <div class="admin-table-card">

        <div class="d-flex flex-wrap justify-content-between
                    align-items-center gap-2 mb-3">

            <h2>All Bookings</h2>

            <span class="booking-count">
                <?= $totalBookings ?>
                <?= $totalBookings === 1 ? 'record' : 'records' ?>
            </span>
        </div>

        <?php if (empty($bookings)): ?>

            <div class="empty-bookings text-center py-5">
                <i class="bi bi-calendar-x display-4 text-secondary"></i>
                <h3 class="mt-3">No bookings yet</h3>
                <p>New customer bookings will appear here.</p>

                <a href="booking.php" class="btn btn-primary">
                    Open Booking Form
                </a>
            </div>

        <?php else: ?>

            <div class="table-responsive">
                <table class="table admin-table table-hover align-middle">

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
                            'Confirmed' => 'confirmed',
                            'Completed' => 'completed',
                            'Cancelled' => 'cancelled',
                            default => 'pending'
                        };

                        $dateTimestamp = strtotime($booking['booking_date']);
                        $timeTimestamp = strtotime($booking['booking_time']);
                        ?>

                        <tr>
                            <td>#<?= (int) $booking['id'] ?></td>

                            <td>
                                <strong><?= e($booking['full_name']) ?></strong>
                                <small>
                                    <i class="bi bi-envelope me-1"></i>
                                    <?= e($booking['email']) ?>
                                </small>
                                <small>
                                    <i class="bi bi-telephone me-1"></i>
                                    <?= e($booking['phone']) ?>
                                </small>
                            </td>

                            <td>
                                <strong><?= e($booking['lesson_type']) ?></strong>
                                <small><?= e($booking['package_name']) ?> Package</small>
                            </td>

                            <td>
                                <div class="appointment-date">
                                    <?= $dateTimestamp !== false
                                        ? e(date('M d, Y', $dateTimestamp))
                                        : e($booking['booking_date']) ?>
                                </div>

                                <div class="appointment-time">
                                    <i class="bi bi-clock me-1"></i>
                                    <?= $timeTimestamp !== false
                                        ? e(date('h:i A', $timeTimestamp))
                                        : e($booking['booking_time']) ?>
                                </div>
                            </td>

                            <td>
                                <span class="status-pill status-<?= e($statusClass) ?>">
                                    <?= e($booking['status']) ?>
                                </span>
                            </td>

                            <td>
                                <form method="POST" class="status-form">

                                    <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?= e($_SESSION['csrf_token']) ?>"
                                    >

                                    <input
                                        type="hidden"
                                        name="booking_id"
                                        value="<?= (int) $booking['id'] ?>"
                                    >

                                    <select
                                        name="status"
                                        class="form-select form-select-sm"
                                        aria-label="Choose booking status"
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

                                    <button type="submit"
                                            class="btn btn-sm btn-update">
                                        <i class="bi bi-check2-circle me-1"></i>
                                        Update Status
                                    </button>

                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
    </div>

</main>

<footer class="admin-footer">
    DriveN School &copy; <?= date('Y') ?> — Booking Management
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>