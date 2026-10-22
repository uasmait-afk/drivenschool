
<?php
session_start();
require __DIR__ . '/config/db.php';

$error = '';
$success = '';

try {
    $count = (int) $pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn();
} catch (PDOException $e) {
    exit('Admin table not found. Please create the admins table first.');
}

if ($count > 0) {
    exit('Admin account already exists. Delete setup-admin.php and use login.php.');
}

if (empty($_SESSION['setup_token'])) {
    $_SESSION['setup_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['setup_token'], $_POST['token'] ?? '')) {
        $error = 'Invalid request. Refresh the page.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!preg_match('/^[a-zA-Z0-9_]{4,50}$/', $username)) {
            $error = 'Username must be 4–50 letters, numbers or underscores.';
        } elseif (strlen($password) < 12) {
            $error = 'Use a password with at least 12 characters.';
        } else {
            try {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare(
                    'INSERT INTO admins (username, password_hash)
                     VALUES (:username, :password_hash)'
                );

                $stmt->execute([
                    'username' => $username,
                    'password_hash' => $hash
                ]);

                $success = 'Admin created! Now delete setup-admin.php and open login.php.';
            } catch (PDOException $e) {
                error_log($e->getMessage());
                $error = 'Could not create the account.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Admin | DriveN School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="admin-page">
<div class="container py-5" style="max-width:520px">
    <div class="admin-table-card">
        <h1 class="h3 mb-2">Create Admin Account</h1>
        <p class="text-secondary">Set up your private dashboard login.</p>

        <?php if ($error !== ''): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php if ($success !== ''): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
        <?php else: ?>
            <form method="POST">
                <input type="hidden" name="token"
                       value="<?= htmlspecialchars($_SESSION['setup_token'], ENT_QUOTES, 'UTF-8') ?>">

                <label class="form-label mt-3">Username</label>
                <input class="form-control" name="username"
                       minlength="4" maxlength="50" required autocomplete="username">

                <label class="form-label mt-3">Password (minimum 12 characters)</label>
                <input class="form-control" type="password" name="password"
                       minlength="12" required autocomplete="new-password">

                <button class="btn btn-primary w-100 mt-4" type="submit">
                    Create Admin
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
