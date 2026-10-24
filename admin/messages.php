
<?php
session_start();

require_once __DIR__ . '/../config/db.php';

// Check that your existing database connection
// uses PDO and the variable is named $pdo.
try {
    $stmt = $pdo->query(
        "SELECT id, name, email, phone, message, created_at
         FROM contact_messages
         ORDER BY created_at DESC"
    );

    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log($e->getMessage());
    exit("Unable to load contact messages. Please check the database connection.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages | DriveN School</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f3f5fa;
            font-family: Arial, sans-serif;
        }

        .dashboard-header {
            background: #101c3a;
            color: white;
            padding: 25px;
            border-radius: 14px;
        }

        .message-card {
            background: white;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(16, 28, 58, .07);
        }

        .brand-accent {
            color: #f5ae35;
        }

        .message-text {
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <div class="dashboard-header mb-4">
        <h1 class="h3 mb-2">
            DriveN <span class="brand-accent">School</span>
        </h1>
        <p class="mb-0">Contact Messages Dashboard</p>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">All Messages</h2>
        <span class="badge text-bg-primary">
            <?= count($messages) ?> Messages
        </span>
    </div>

    <?php if (empty($messages)): ?>

        <div class="alert alert-info">
            No contact messages found yet.
        </div>

    <?php else: ?>

        <?php foreach ($messages as $message): ?>
            <div class="card message-card mb-3">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between flex-wrap gap-2">
                        <h3 class="h5">
                            <?= htmlspecialchars($message['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>

                        <small class="text-muted">
                            <?= htmlspecialchars($message['created_at'], ENT_QUOTES, 'UTF-8') ?>
                        </small>
                    </div>

                    <p class="mb-1">
                        <strong>Email:</strong>
                        <?= htmlspecialchars($message['email'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <p class="mb-3">
                        <strong>Phone:</strong>
                        <?= htmlspecialchars($message['phone'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <div class="message-text mb-3"><?= htmlspecialchars($message['message'], ENT_QUOTES, 'UTF-8') ?></div>

                    <a
                        class="btn btn-sm btn-outline-primary"
                        href="mailto:<?= htmlspecialchars($message['email'], ENT_QUOTES, 'UTF-8') ?>"
                    >
                        Reply by Email
                    </a>

                    <a
                        class="btn btn-sm btn-outline-secondary"
                        href="tel:<?= htmlspecialchars($message['phone'], ENT_QUOTES, 'UTF-8') ?>"
                    >
                        Call
                    </a>

                </div>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>

    <a href="../index.php" class="btn btn-dark mt-3">
        Back to Website
    </a>

</div>

</body>
</html>
