
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/db.php';

if (isset($_SESSION['student_id'])) {
    header('Location: student-dashboard.php');
    exit;
}

if (empty($_SESSION['student_csrf'])) {
    $_SESSION['student_csrf'] = bin2hex(random_bytes(32));
}

$error = '';
$registered = isset($_GET['registered']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $token = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['student_csrf'], $token)) {
        $error = 'Invalid request. Refresh the page and try again.';
    } else {
        $stmt = $pdo->prepare(
            'SELECT id, full_name, email, password_hash
             FROM students WHERE email = :email LIMIT 1'
        );
        $stmt->execute(['email' => $email]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student && password_verify(
            $password,
            $student['password_hash']
        )) {
            session_regenerate_id(true);

            $_SESSION['student_id'] = (int) $student['id'];
            $_SESSION['student_name'] = $student['full_name'];
            $_SESSION['student_email'] = $student['email'];

            header('Location: student-dashboard.php');
            exit;
        }

        $error = 'Incorrect email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Login | DriveN School</title>
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
            max-width: 450px;
            padding: 32px;
            background: #101d35;
            border: 1px solid #263754;
            border-radius: 18px;
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
        a { color: #f5a623; }
    </style>
</head>
<body>
<div class="auth-card">
    <h2 class="brand mb-2">DriveN School</h2>
    <h4 class="mb-4">Student Login</h4>

    <?php if ($registered): ?>
        <div class="alert alert-success">
            Account created. You can log in now.
        </div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf_token"
               value="<?= htmlspecialchars($_SESSION['student_csrf']) ?>">

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input class="form-control" type="email" name="email"
                   autocomplete="username" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password"
                   autocomplete="current-password" required>
        </div>

        <button class="btn btn-gold w-100" type="submit">
            Login
        </button>
    </form>

    <p class="mt-4 mb-0">
        Don't have an account?
        <a href="student-register.php">Register Now</a>
    </p>
    <a class="d-inline-block mt-3" href="index.php">← Back to Home</a>
</div>
</body>
</html>
