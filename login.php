
<?php
session_start();
require __DIR__ . '/config/db.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: admin.php');
    exit;
}

if (empty($_SESSION['login_token'])) {
    $_SESSION['login_token'] = bin2hex(random_bytes(32));
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['login_token'], $_POST['token'] ?? '')) {
        $error = 'Invalid request. Please refresh the page.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare(
            'SELECT id, username, password_hash
             FROM admins WHERE username = :username LIMIT 1'
        );
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int) $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            unset($_SESSION['login_token']);

            header('Location: admin.php');
            exit;
        }

        $error = 'Incorrect username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | DriveN School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="admin-page">
<div class="container py-5" style="max-width:480px">
    <div class="admin-table-card">
        <a href="index.php" class="admin-brand" style="color:#142544">
            DriveN <span>School</span>
        </a>
        <h1 class="h3 mt-4">Admin Login</h1>
        <p class="text-secondary">Sign in to manage bookings.</p>

        <?php if ($error !== ''): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="token"
                   value="<?= htmlspecialchars($_SESSION['login_token'], ENT_QUOTES, 'UTF-8') ?>">

            <label class="form-label mt-3">Username</label>
            <input class="form-control" name="username"
                   required autocomplete="username">

            <label class="form-label mt-3">Password</label>
            <input class="form-control" type="password" name="password"
                   required autocomplete="current-password">

            <button class="btn btn-primary w-100 mt-4" type="submit">
                Sign In
            </button>
        </form>
    </div>
</div>
</body>
</html>
