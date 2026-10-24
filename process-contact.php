
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php#contact");
    exit;
}

require_once __DIR__ . "/config/db.php";

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$message = trim($_POST["message"] ?? "");

$errors = [];

if ($name === "" || strlen($name) > 100) {
    $errors[] = "Please enter a valid name.";
}

if (
    $email === "" ||
    strlen($email) > 150 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    $errors[] = "Please enter a valid email address.";
}

if ($phone === "" || strlen($phone) > 30) {
    $errors[] = "Please enter a valid phone number.";
}

if ($message === "" || strlen($message) > 5000) {
    $errors[] = "Message is required and must be under 5000 characters.";
}

if ($errors) {
    $_SESSION["contact_errors"] = $errors;
    header("Location: index.php#contact");
    exit;
}

try {
    $sql = "INSERT INTO contact_messages
            (name, email, phone, message)
            VALUES (:name, :email, :phone, :message)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":name" => $name,
        ":email" => $email,
        ":phone" => $phone,
        ":message" => $message
    ]);

    $_SESSION["contact_success"] =
        "Thank you! Your message has been sent successfully.";

} catch (PDOException $e) {
    error_log($e->getMessage());

    $_SESSION["contact_errors"] = [
        "Sorry, your message could not be saved. Please try again."
    ];
}

header("Location: index.php#contact");
exit;
