
<?php
session_start();

require_once __DIR__ . '/config/db.php';

// Protect this page: admin must be logged in.
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

function e($value): string
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}

$allowedStatuses = [
    'Pending',
    'Confirmed',
    'Cancelled'
];

$error = '';
$success = '';

// Update enrollment status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enrollmentId = filter_input(
        INPUT_POST,
        'enrollment_id',
        FILTER_VALIDATE_INT
    );

    $status = $_POST['status'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (
        empty($_SESSION['csrf_token']) ||
        !is_string($csrfToken) ||
        !hash_equals($_SESSION['csrf_token'], $csrfToken)
    ) {
        $error = 'Security check failed. Refresh the page.';
    } elseif (
        !$enrollmentId ||
        !in_array($status, $allowedStatuses, true)
    ) {
        $error = 'Invalid enrollment or status.';
    } else {
        $stmt = $pdo->prepare(
            'UPDATE enrollments
             SET status = ?
             WHERE id = ?'
        );

        $stmt->execute([$status, $enrollmentId]);

        $success = $stmt->rowCount() > 0
            ? 'Enrollment status updated successfully.'
            : 'No record changed. It may already have this status.';
    }
}

// Load enrollment records
try {
    $stmt = $pdo->query(
        'SELECT *
         FROM enrollments
         ORDER BY created_at DESC'
    );

    $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log($e->getMessage());
    $enrollments = [];
    $error = 'Unable to load enrollment records. Please try again.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Enrollment Management | DriveN School</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-car-front-fill text-warning"></i>
            DriveN School
        </a>

        <span class="text-white">
            <i class="bi bi-person-lock"></i>
            Admin Panel
        </span>
    </div>
</nav>

<main class="container-fluid px-4 py-5">

    <div class="d-flex flex-wrap justify-content-between
                align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold">Enrollment Management</h1>
            <p class="text-secondary mb-0">
                View enrollment requests and manage their status.
            </p>
        </div>

        <span class="badge text-bg-primary fs-6">
            Total: <?= count($enrollments) ?>
        </span>
    </div>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success !== ''): ?>
        <div class="alert alert-success">
            <?= e($success) ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <?php if (empty($enrollments)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-secondary"></i>
                    <h2 class="h5 mt-3">No enrollments yet</h2>
                    <p class="text-secondary">
                        Submitted enrollment requests will appear here.
                    </p>
                </div>
            <?php else: ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Package</th>
                                <th>Price</th>
                                <th>Preferred Date</th>
                                <th>Preferred Time</th>
                                <th>Status</th>
                                <th>Update</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($enrollments as $item): ?>
                            <tr>
                                <td><?= (int) $item['id'] ?></td>

                                <td>
                                    <strong><?= e($item['full_name']) ?></strong>
                                    <br>
                                    <small><?= e($item['email']) ?></small>
                                    <br>
                                    <small><?= e($item['phone']) ?></small>
                                </td>

                                <td><?= e($item['package_name']) ?></td>

                                <td>
                                    $<?= number_format(
                                        (float) $item['package_price'],
                                        2
                                    ) ?>
                                </td>

                                <td><?= e($item['preferred_date']) ?></td>

                                <td>
                                    <?= e(date(
                                        'g:i A',
                                        strtotime($item['preferred_time'])
                                    )) ?>
                                </td>

                                <td>
                                    <?php
                                    $badgeClass = match ($item['status']) {
                                        'Confirmed' => 'success',
                                        'Cancelled' => 'danger',
                                        default => 'warning text-dark'
                                    };
                                    ?>
                                    <span class="badge text-bg-<?= $badgeClass ?>">
                                        <?= e($item['status']) ?>
                                    </span>
                                </td>

                                <td>
                                    <form method="POST" class="d-flex gap-2">
                                        <input
                                            type="hidden"
                                            name="csrf_token"
                                            value="<?= e($_SESSION['csrf_token'] ?? '') ?>"
                                        >

                                        <input
                                            type="hidden"
                                            name="enrollment_id"
                                            value="<?= (int) $item['id'] ?>"
                                        >

                                        <select
                                            name="status"
                                            class="form-select form-select-sm"
                                            required
                                        >
                                            <?php foreach ($allowedStatuses as $option): ?>
                                                <option
                                                    value="<?= e($option) ?>"
                                                    <?= $item['status'] === $option
                                                        ? 'selected'
                                                        : '' ?>
                                                >
                                                    <?= e($option) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-sm"
                                        >
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
    </div>
</main>

</body>
</html>
