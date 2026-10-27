
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/db.php';

if (isset($_SESSION['student_id'])) {
    header('Location: student-dashboard.php');
    exit;
}

$error = '';

if (empty($_SESSION['student_csrf'])) {
    $_SESSION['student_csrf'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $token = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['student_csrf'], $token)) {
        $error = 'Invalid request. Please refresh and try again.';
    } elseif ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid name and email.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must contain at least 8 characters.';
    } else {
        try {
            $check = $pdo->prepare(
                'SELECT id FROM students WHERE email = :email'
            );
            $check->execute(['email' => $email]);

            if ($check->fetch()) {
                $error = 'This email is already registered.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare(
                    'INSERT INTO students
                    (full_name, email, phone, password_hash)
                    VALUES (:name, :email, :phone, :hash)'
                );

                $stmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone !== '' ? $phone : null,
                    'hash' => $hash
                ]);

                header('Location: student-login.php?registered=1');
                exit;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $error = 'Registration failed. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Registration | DriveN School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <style>
        body {
            background: #091426;
            color: #fff;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            font-family: Arial, sans-serif;
        }
        .auth-card {
            width: 100%;
            max-width: 480px;
            background: #101d35;
            padding: 32px;
            border-radius: 18px;
            border: 1px solid #263754;
        }
        .brand { color: #f5a623; font-weight: 800; }
        .form-control {
            background: #091426;
            color: #fff;
            border-color: #34445f;
            padding: 12px;
        }
        .form-control:focus {
            background: #091426;
            color: #fff;
            border-color: #f5a623;
            box-shadow: none;
        }
        .btn-gold {
            background: #f5a623;
            color: #101d35;
            font-weight: 700;
            padding: 12px;
        }
        .btn-gold:hover { background: #ffbb4c; }
        a { color: #f5a623; }
    </style>
</head>
<body>
<div class="auth-card">
    <h2 class="brand mb-2">DriveN School</h2>
    <h4 class="mb-4">Create Student Account</h4>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf_token"
               value="<?= htmlspecialchars($_SESSION['student_csrf']) ?>">

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input class="form-control" name="full_name"
                   maxlength="100" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input class="form-control" type="email" name="email"
                   maxlength="190" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input class="form-control" type="tel" name="phone"
                   maxlength="30">
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password"
                   minlength="8" autocomplete="new-password" required>
            <small class="text-secondary">At least 8 characters</small>
        </div>

        <button class="btn btn-gold w-100" type="submit">
            Create Account
        </button>
    </form>

    <p class="mt-4 mb-0">
        Already registered?
        <a href="student-login.php">Student Login</a>
    </p>
    <a class="d-inline-block mt-3" href="index.php">← Back to Home</a>
</div>
</body>
</html>
