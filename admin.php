
<?php
session_start();

require __DIR__ . '/config/db.php';

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

    if (!hash_equals($_SESSION['csrf_token'], $token)) {
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
                    'UPDATE bookings SET status = :status WHERE id = :id'
                );

                $stmt->execute([
                    'status' => $newStatus,
                    'id' => $bookingId
                ]);

                $message = 'Booking status updated successfully!';
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

    $bookings = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $bookings = [];
    $error = 'Could not load bookings. Check your database table.';
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | DriveN School</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="admin-page">

<header class="admin-header">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="index.php" class="admin-brand">
            DriveN <span>School</span>
        </a>
        <a href="index.php" class="btn btn-outline-light btn-sm">
            View Website
        </a>
        <form action="logout.php" method="POST" class="d-inline">
    <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>"
    >
    <button type="submit" class="btn btn-warning btn-sm">Logout</button>
</form>
    </div>
    
</header>

<main class="container py-5">
    <div class="admin-heading mb-4">
        <p class="admin-eyebrow">MANAGEMENT CENTER</p>
        <h1>Booking Dashboard</h1>
        <p>Manage customer appointments and booking status.</p>
    </div>

    <?php if ($message !== ''): ?>
        <div class="alert alert-success">
            <?= e($message) ?>
        </div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <div class="admin-stats mb-4">
        <div class="admin-stat">
            <span>Total Bookings</span>
            <strong><?= count($bookings) ?></strong>
        </div>
        <div class="admin-stat">
            <span>Pending</span>
            <strong>
                <?= count(array_filter(
                    $bookings,
                    fn($b) => $b['status'] === 'Pending'
                )) ?>
            </strong>
        </div>
        <div class="admin-stat">
            <span>Confirmed</span>
            <strong>
                <?= count(array_filter(
                    $bookings,
                    fn($b) => $b['status'] === 'Confirmed'
                )) ?>
            </strong>
        </div>
    </div>

    <div class="admin-table-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>All Bookings</h2>
            <span class="booking-count">
                <?= count($bookings) ?> records
            </span>
        </div>

        <?php if (count($bookings) === 0): ?>
            <div class="empty-bookings">
                <h3>No bookings yet</h3>
                <p>New customer bookings will appear here.</p>
                <a href="booking.php" class="btn btn-primary">
                    Open Booking Form
                </a>
            </div>
        <?php else: ?>

        <div class="table-responsive">
            <table class="table admin-table align-middle">
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
                    <tr>
                        <td>#<?= e($booking['id']) ?></td>

                        <td>
                            <strong><?= e($booking['full_name']) ?></strong>
                            <small><?= e($booking['email']) ?></small>
                            <small><?= e($booking['phone']) ?></small>
                        </td>

                        <td>
                            <strong><?= e($booking['lesson_type']) ?></strong>
                            <small><?= e($booking['package_name']) ?> Package</small>
                        </td>

                        <td>
                            <?= e($booking['booking_date']) ?>
                            <small><?= e($booking['booking_time']) ?></small>
                        </td>

                        <td>
                            <span class="status-pill status-<?= strtolower(e($booking['status'])) ?>">
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
                                    value="<?= e($booking['id']) ?>"
                                >

                                <select name="status" class="form-select form-select-sm">
                                    <?php foreach ($allowedStatuses as $status): ?>
                                        <option
                                            value="<?= e($status) ?>"
                                            <?= $booking['status'] === $status ? 'selected' : '' ?>
                                        >
                                            <?= e($status) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <button type="submit" class="btn btn-sm btn-update">
                                    Save
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

</body>
</html>
