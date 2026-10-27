
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: student-dashboard.php');
    exit;
}

$token = $_POST['csrf_token'] ?? '';
$sessionToken = $_SESSION['student_csrf'] ?? '';

if (
    !is_string($token) ||
    !is_string($sessionToken) ||
    $sessionToken === '' ||
    !hash_equals($sessionToken, $token)
) {
    http_response_code(403);
    exit('Invalid request. Please return to the dashboard.');
}

unset(
    $_SESSION['student_id'],
    $_SESSION['student_name'],
    $_SESSION['student_email']
);

session_regenerate_id(true);

header('Location: student-login.php?logged_out=1');
exit;
