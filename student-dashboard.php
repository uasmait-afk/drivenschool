<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['student_csrf'])) {
    $_SESSION['student_csrf'] = bin2hex(random_bytes(32));
}
require_once __DIR__ . '/config/db.php';

if (empty($_SESSION['student_id'])) {
    header('Location: student-login.php');
    exit;
}

$studentId = (int) $_SESSION['student_id'];

$stmt = $pdo->prepare(
    'SELECT id, lesson_type, package_name, booking_date,
            booking_time, status, created_at
     FROM bookings
     WHERE student_id = :student_id
     ORDER BY created_at DESC'
);

$stmt->execute(['student_id' => $studentId]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

$name = $_SESSION['student_name'] ?? 'Student';

function e($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard | DriveN School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
    body {
        background: #091426;
        color: #fff;
        font-family: Arial, sans-serif;
    }

    .topbar {
        background: #101d35;
        border-bottom: 1px solid #263754;
    }

    .brand {
        color: #f5a623;
        font-weight: 800;
    }

    .panel {
        background: #101d35;
        border: 1px solid #263754;
        border-radius: 16px;
        padding: 24px;
    }

    .stat {
        color: #f5a623;
        font-size: 2rem;
        font-weight: 800;
    }

    .btn-gold {
        background: #f5a623;
        color: #101d35;
        font-weight: 700;
    }

    .table {
        --bs-table-bg: transparent;
        --bs-table-color: #fff;
    }

    .table td,
    .table th {
        border-color: #34445f;
        padding: 14px 10px;
    }

    .muted {
        color: #b7c3d7;
    }
    </style>
</head>

<body>
    <nav class="topbar py-3">
        <div class="container d-flex justify-content-between align-items-center gap-3">
            <a class="brand text-decoration-none fs-4" href="index.php">
                DriveN School
            </a>

            <form action="student-logout.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['student_csrf']) ?>">
                <button type="submit" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>

        </div>
    </nav>

    <main class="container py-5">
        <div class="mb-4">
            <p class="brand mb-2">STUDENT PORTAL</p>
            <h1 class="h2">Welcome, <?= e($name) ?>!</h1>
            <p class="muted">Manage your driving lessons and bookings.</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="panel h-100">
                    <p class="muted mb-2">Total Linked Bookings</p>
                    <div class="stat"><?= count($bookings) ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel h-100">
                    <p class="muted mb-2">Account Email</p>
                    <div class="fw-semibold text-break">
                        <?= e($_SESSION['student_email'] ?? '') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                <div>
                    <h2 class="h4 mb-1">My Bookings</h2>
                    <p class="muted mb-0">Your lesson booking history.</p>
                </div>
                <a href="booking.php" class="btn btn-gold">
                    <i class="bi bi-plus-circle"></i> Book a Lesson
                </a>
            </div>

            <?php if (!$bookings): ?>
            <div class="text-center py-5">
                <i class="bi bi-calendar2-check display-4 brand"></i>
                <h3 class="h5 mt-3">No linked bookings yet</h3>
                <p class="muted">
                    Book a lesson while logged in to see it here.
                </p>
                <a href="booking.php" class="btn btn-gold">
                    Book Your First Lesson
                </a>
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Booking</th>
                            <th>Lesson</th>
                            <th>Package</th>
                            <th>Date &amp; Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                        <?php
                        $status = strtolower((string) $booking['status']);
                        $badge = match ($status) {
                            'confirmed' => 'success',
                            'completed' => 'primary',
                            'cancelled' => 'danger',
                            default => 'warning'
                        };
                        ?>
                        <tr>
                            <td>#<?= (int) $booking['id'] ?></td>
                            <td><?= e($booking['lesson_type']) ?></td>
                            <td><?= e($booking['package_name']) ?></td>
                            <td>
                                <?= e($booking['booking_date']) ?><br>
                                <small class="muted">
                                    <?= e($booking['booking_time']) ?>
                                </small>
                            </td>
                            <td>
                                <span class="badge text-bg-<?= $badge ?>">
                                    <?= e(ucfirst($status)) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>