<?php
declare(strict_types=1);

require __DIR__ . '/config/db.php';

$paymentId = trim((string)($_GET['payment_id'] ?? ''));
$payment = null;

if ($paymentId !== '' && strlen($paymentId) <= 100) {
    $stmt = $pdo->prepare(
        "SELECT square_payment_id, amount_cents, currency, created_at
         FROM payments
         WHERE square_payment_id = ?
           AND payment_status = 'completed'
         LIMIT 1"
    );
    $stmt->execute([$paymentId]);
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Payment Receipt | DriveN School</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root{--navy:#101d35;--deep:#091426;--gold:#f5a623}
body{background:#f3f6fb;color:var(--navy);font-family:Arial,sans-serif}
.navbar{background:var(--deep)}
.brand{color:#fff;font-weight:800;text-decoration:none;font-size:1.3rem}
.brand span{color:var(--gold)}
.receipt{max-width:650px;margin:65px auto;background:#fff;border-radius:22px;padding:38px;box-shadow:0 18px 55px #101d3514}
.success-icon{font-size:3.5rem;color:#16865c}
.btn-gold{background:var(--gold);color:var(--deep);font-weight:700;border:0}
</style>
</head>
<body>
<nav class="navbar py-3">
    <div class="container">
        <a class="brand" href="index.php">Drive<span>N</span> School</a>
    </div>
</nav>

<main class="container">
<div class="receipt text-center">
<?php if ($payment): ?>
    <div class="success-icon">&#10003;</div>
    <h1 class="fw-bold mt-3">Payment confirmed</h1>
    <p class="text-secondary">Your payment record has been confirmed by DriveN School.</p>
    <hr class="my-4">
    <div class="text-start">
        <p><strong>Payment ID:</strong><br>
            <?= htmlspecialchars($payment['square_payment_id'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <p><strong>Amount:</strong><br>
            <?= htmlspecialchars($payment['currency'], ENT_QUOTES, 'UTF-8') ?>
            <?= number_format(((int)$payment['amount_cents']) / 100, 2) ?>
        </p>
        <p><strong>Date:</strong><br>
            <?= htmlspecialchars($payment['created_at'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <p><strong>Status:</strong> Completed</p>
    </div>
    <a href="index.php" class="btn btn-gold w-100 py-3 mt-3">Back to Home</a>
<?php else: ?>
    <h1 class="fw-bold">Receipt unavailable</h1>
    <p class="text-secondary">
        We could not find a confirmed payment record. Do not assume payment succeeded.
        If your account was charged, contact DriveN School before trying again.
    </p>
    <a href="checkout.php" class="btn btn-gold w-100 py-3">Return to Checkout</a>
<?php endif; ?>
</div>
</main>
</body>
</html>
