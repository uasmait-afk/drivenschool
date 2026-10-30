<?php
declare(strict_types=1);

require __DIR__ . '/config/db.php';

$paymentId = trim((string)($_GET['payment_id'] ?? ''));

$payment = null;
$order = null;
$items = [];

if ($paymentId !== '' && strlen($paymentId) <= 100) {

    $stmt = $pdo->prepare("
        SELECT
            p.square_payment_id,
            p.amount_cents,
            p.currency,
            p.created_at,
            p.order_id,
            o.order_number,
            o.full_name,
            o.email,
            o.phone,
            o.order_status
        FROM payments p
        INNER JOIN orders o ON o.id = p.order_id
        WHERE p.square_payment_id = ?
          AND p.payment_status = 'completed'
          AND o.order_status = 'paid'
        LIMIT 1
    ");

    $stmt->execute([$paymentId]);
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($payment) {

        $stmt = $pdo->prepare("
            SELECT
                product_name,
                product_code,
                unit_price_cents,
                quantity,
                line_total_cents
            FROM order_items
            WHERE order_id = ?
            ORDER BY id ASC
        ");

        $stmt->execute([$payment['order_id']]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
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
:root {
    --navy: #101d35;
    --deep: #091426;
    --gold: #f5a623;
}

body {
    background: #f3f6fb;
    color: var(--navy);
    font-family: Arial, sans-serif;
}

.navbar {
    background: var(--deep);
}

.brand {
    color: #fff;
    font-weight: 800;
    text-decoration: none;
    font-size: 1.3rem;
}

.brand span {
    color: var(--gold);
}

.receipt {
    max-width: 700px;
    margin: 55px auto;
    background: #fff;
    border-radius: 22px;
    padding: 38px;
    box-shadow: 0 18px 55px #101d3514;
}

.success-icon {
    font-size: 3.5rem;
    color: #16865c;
}

.btn-gold {
    background: var(--gold);
    color: var(--deep);
    font-weight: 700;
    border: 0;
}

.btn-gold:hover {
    background: #ffbb4c;
    color: var(--deep);
}

.table th {
    color: var(--navy);
}

.receipt-label {
    color: #6c757d;
    font-size: .9rem;
}

@media(max-width:576px) {
    .receipt {
        padding: 22px;
        margin: 25px auto;
    }
}
</style>
</head>

<body>

<nav class="navbar py-3">
    <div class="container">
        <a class="brand" href="index.php">
            Drive<span>N</span> School
        </a>
    </div>
</nav>

<main class="container">

<div class="receipt">

<?php if ($payment && count($items) > 0): ?>

    <div class="text-center">

        <div class="success-icon">&#10003;</div>

        <h1 class="fw-bold mt-3">
            Payment confirmed
        </h1>

        <p class="text-secondary">
            Thank you! Your payment has been successfully confirmed.
        </p>

        <span class="badge bg-success px-3 py-2">
            PAYMENT COMPLETED
        </span>

    </div>

    <hr class="my-4">

    <h5 class="fw-bold mb-3">Order Information</h5>

    <div class="row g-3">

        <div class="col-md-6">
            <div class="receipt-label">Order Number</div>
            <strong><?= e($payment['order_number']) ?></strong>
        </div>

        <div class="col-md-6">
            <div class="receipt-label">Customer Name</div>
            <strong><?= e($payment['full_name']) ?></strong>
        </div>

        <div class="col-md-6">
            <div class="receipt-label">Email</div>
            <strong><?= e($payment['email']) ?></strong>
        </div>

        <div class="col-md-6">
            <div class="receipt-label">Phone</div>
            <strong><?= e($payment['phone']) ?></strong>
        </div>

    </div>

    <hr class="my-4">

    <h5 class="fw-bold mb-3">Purchased Packages</h5>

    <div class="table-responsive">

        <table class="table table-bordered align-middle">

            <thead class="table-light">
                <tr>
                    <th>Package</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($items as $item): ?>

                <tr>
                    <td>
                        <strong><?= e($item['product_name']) ?></strong>
                        <br>
                        <small class="text-secondary">
                            <?= e($item['product_code']) ?>
                        </small>
                    </td>

                    <td><?= (int)$item['quantity'] ?></td>

                    <td>
                        $<?= number_format(
                            ((int)$item['unit_price_cents']) / 100,
                            2
                        ) ?>
                    </td>

                    <td>
                        $<?= number_format(
                            ((int)$item['line_total_cents']) / 100,
                            2
                        ) ?>
                    </td>
                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <div class="text-end mb-4">

        <div class="receipt-label">Total Paid</div>

        <h2 class="fw-bold">
            <?= e($payment['currency']) ?>
            <?= number_format(
                ((int)$payment['amount_cents']) / 100,
                2
            ) ?>
        </h2>

    </div>

    <hr>

    <div class="mb-3">
        <div class="receipt-label">Square Payment ID</div>
        <strong class="text-break">
            <?= e($payment['square_payment_id']) ?>
        </strong>
    </div>

    <div class="mb-3">
        <div class="receipt-label">Payment Date</div>
        <strong><?= e($payment['created_at']) ?></strong>
    </div>

    <div class="mb-3">
        <div class="receipt-label">Payment Status</div>
        <strong class="text-success">Completed</strong>
    </div>

    <a href="index.php"
       class="btn btn-gold w-100 py-3 mt-3">
        Back to Home
    </a>

<?php else: ?>

    <div class="text-center">

        <h1 class="fw-bold">Receipt unavailable</h1>

        <p class="text-secondary mt-3">
            We could not find a confirmed payment and order record.
            Do not assume payment succeeded.
            If your account was charged, contact DriveN School
            before trying again.
        </p>

        <a href="index.php"
           class="btn btn-gold w-100 py-3">
            Back to Home
        </a>

    </div>

<?php endif; ?>

</div>

</main>

</body>
</html>
