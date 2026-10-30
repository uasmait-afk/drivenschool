<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/config/db.php';

$square = require __DIR__ . '/config/square.php';

if (empty($_SESSION['payment_csrf'])) {
    $_SESSION['payment_csrf'] = bin2hex(random_bytes(32));
}

$csrf = $_SESSION['payment_csrf'];
$appId = $square['application_id'];
$locationId = $square['location_id'];
$isSandbox = ($square['environment'] === 'sandbox');

/*
|--------------------------------------------------------------------------
| Load cart and verify products from database
|--------------------------------------------------------------------------
*/

$cart = $_SESSION['cart'] ?? [];

if (!is_array($cart) || empty($cart)) {
    header('Location: cart.php');
    exit;
}

$cartItems = [];
$grandTotal = 0;
$totalItems = 0;

try {
    foreach ($cart as $key => $item) {

        $productId = (int)($item['product_id'] ?? $key);
        $quantity = (int)($item['quantity'] ?? 1);

        if ($productId < 1 || $quantity < 1 || $quantity > 20) {
            throw new RuntimeException('Invalid cart item.');
        }

        $stmt = $pdo->prepare("
            SELECT id, product_code, product_name, price_cents
            FROM products
            WHERE id = ?
              AND is_active = 1
            LIMIT 1
        ");

        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            throw new RuntimeException(
                'A selected product is no longer available. Please review your cart.'
            );
        }

        $price = (int)$product['price_cents'];
        $subtotal = $price * $quantity;

        $cartItems[] = [
            'key' => (string)$key,
            'product_id' => (int)$product['id'],
            'product_code' => $product['product_code'],
            'name' => $product['product_name'],
            'price' => $price,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
        ];

        $grandTotal += $subtotal;
        $totalItems += $quantity;
    }

} catch (Throwable $e) {

    error_log('Checkout cart error: ' . $e->getMessage());

    http_response_code(400);
    exit(
        'Your cart could not be verified. Please return to your cart and try again.'
    );
}

if (empty($cartItems) || $grandTotal < 1) {
    header('Location: cart.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Secure Checkout | DriveN School</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<script src="<?= $isSandbox
    ? 'https://sandbox.web.squarecdn.com/v1/square.js'
    : 'https://web.squarecdn.com/v1/square.js' ?>"></script>

<style>
:root {
    --navy: #101d35;
    --navy-deep: #091426;
    --blue: #2878f0;
    --gold: #f5a623;
    --gold-hover: #ffbb4c;
}

body {
    background: #f3f6fb;
    color: var(--navy);
    font-family: "DM Sans", Arial, sans-serif;
}

.navbar {
    background: var(--navy-deep);
}

.brand {
    color: white;
    font-weight: 800;
    letter-spacing: .3px;
    text-decoration: none;
}

.brand span {
    color: var(--gold);
}

.checkout-wrap {
    max-width: 1100px;
    margin: 55px auto;
}

.checkout-card {
    background: white;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 20px 55px rgba(16,29,53,.09);
}

.checkout-main {
    padding: 35px;
}

.summary {
    height: 100%;
    padding: 35px;
    color: white;
    background: linear-gradient(145deg,var(--navy),var(--navy-deep));
}

.eyebrow {
    color: var(--gold);
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    font-size: .76rem;
}

.form-control {
    min-height: 49px;
    border-radius: 10px;
    border-color: #dce3ee;
}

.form-control:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 .2rem rgba(40,120,240,.12);
}

#card-container {
    min-height: 55px;
    padding: 13px;
    border: 1px solid #dce3ee;
    border-radius: 10px;
    background: #fff;
}

.pay-btn {
    background: var(--gold);
    color: var(--navy-deep);
    border: 0;
    border-radius: 12px;
    padding: 15px;
    font-weight: 800;
}

.pay-btn:hover {
    background: var(--gold-hover);
}

.pay-btn:disabled {
    opacity: .6;
}

.amount {
    color: var(--gold);
    font-size: 2rem;
    font-weight: 800;
}

.cart-item {
    border-bottom: 1px solid rgba(255,255,255,.15);
    padding: 13px 0;
}

#message {
    display: none;
}

@media(max-width:767px) {
    .checkout-wrap {
        margin: 25px 12px;
    }

    .checkout-main,
    .summary {
        padding: 25px;
    }
}
</style>

</head>

<body>

<nav class="navbar py-3">
    <div class="container">

        <a class="navbar-brand brand" href="index.php">
            Drive<span>N</span> School
        </a>

        <span class="text-white small">
            <i class="bi bi-shield-lock"></i>
            Secure Checkout
        </span>

    </div>
</nav>

<main class="checkout-wrap">

    <div class="mb-4">

        <div class="eyebrow">Almost there</div>

        <h1 class="fw-bold mt-2">Complete your payment</h1>

        <p class="text-secondary mb-0">
            Enter your information and pay securely using Square.
        </p>

    </div>

    <?php if ($isSandbox): ?>

        <div class="alert alert-warning">
            <strong>Sandbox testing mode:</strong>
            No real payment should be taken.
        </div>

    <?php endif; ?>

    <div class="checkout-card">

        <div class="row g-0">

            <!-- Customer and Payment Form -->

            <section class="col-lg-7 checkout-main">

                <h4 class="fw-bold mb-4">
                    Customer Information
                </h4>

                <div id="message" class="alert" role="alert"></div>

                <form id="checkout-form">

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Full Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="full_name"
                            name="full_name"
                            maxlength="150"
                            placeholder="Enter your full name"
                            autocomplete="name"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Email Address
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            maxlength="150"
                            placeholder="Enter your email address"
                            autocomplete="email"
                            required
                        >

                    </div>

                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Phone Number
                        </label>

                        <input
                            type="tel"
                            class="form-control"
                            id="phone"
                            name="phone"
                            maxlength="30"
                            placeholder="Enter your phone number"
                            autocomplete="tel"
                            required
                        >

                    </div>

                    <hr class="my-4">

                    <h4 class="fw-bold mb-3">
                        Payment Details
                    </h4>

                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Booking ID
                            <span class="text-secondary fw-normal">
                                (optional)
                            </span>
                        </label>

                        <input
                            class="form-control"
                            type="number"
                            min="1"
                            id="booking_id"
                            placeholder="Enter your existing booking ID"
                        >

                    </div>

                    <label class="form-label fw-semibold">
                        Card Details
                    </label>

                    <div id="card-container"></div>

                    <div class="form-text mb-4">
                        Your card details are handled by Square's secure payment fields.
                    </div>

                    <button
                        class="btn pay-btn w-100"
                        id="pay-button"
                        type="submit"
                    >

                        <i class="bi bi-lock-fill me-2"></i>

                        <span id="button-text">
                            Pay $<?= number_format($grandTotal / 100, 2) ?> USD
                        </span>

                    </button>

                    <p class="text-secondary small text-center mt-3 mb-0">

                        <i class="bi bi-shield-check"></i>

                        Secure checkout powered by Square

                    </p>

                </form>

            </section>

            <!-- Order Summary -->

            <aside class="col-lg-5">

                <div class="summary">

                    <div class="eyebrow">Your Order</div>

                    <h3 class="fw-bold mt-2">
                        Order Summary
                    </h3>

                    <p class="text-white-50">
                        <?= $totalItems ?> item(s)
                    </p>

                    <hr class="border-secondary my-4">

                    <?php foreach ($cartItems as $item): ?>

                        <div class="cart-item">

                            <div class="d-flex justify-content-between gap-2">

                                <div>

                                    <strong>
                                        <?= htmlspecialchars(
                                            $item['name'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </strong>

                                    <div class="small text-white-50">
                                        $<?= number_format($item['price'] / 100, 2) ?>
                                        × <?= $item['quantity'] ?>
                                    </div>

                                </div>

                                <strong>
                                    $<?= number_format($item['subtotal'] / 100, 2) ?>
                                </strong>

                            </div>

                        </div>

                    <?php endforeach; ?>

                    <div class="d-flex justify-content-between mt-4 mb-3">

                        <span class="text-white-50">Subtotal</span>

                        <span>
                            $<?= number_format($grandTotal / 100, 2) ?>
                        </span>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-white-50">Tax</span>

                        <span>$0.00</span>

                    </div>

                    <hr class="border-secondary">

                    <div class="d-flex justify-content-between align-items-center">

                        <span class="fw-semibold">Total</span>

                        <span class="amount">
                            $<?= number_format($grandTotal / 100, 2) ?>
                        </span>

                    </div>

                    <div class="mt-5 small text-white-50">

                        <i class="bi bi-info-circle me-1"></i>

                        The final amount will be validated on the server.

                    </div>

                    <a href="cart.php"
                       class="btn btn-outline-light btn-sm w-100 mt-4">

                        <i class="bi bi-arrow-left"></i>

                        Back to Cart

                    </a>

                </div>

            </aside>

        </div>

    </div>

</main>

<script>
const appId = <?= json_encode($appId) ?>;
const locationId = <?= json_encode($locationId) ?>;
const csrfToken = <?= json_encode($csrf) ?>;

const button = document.getElementById('pay-button');
const buttonText = document.getElementById('button-text');
const messageBox = document.getElementById('message');

const checkoutForm = document.getElementById('checkout-form');

function showMessage(text, success = false) {

    messageBox.style.display = 'block';

    messageBox.className = 'alert ' +
        (success ? 'alert-success' : 'alert-danger');

    messageBox.textContent = text;
}

async function startCheckout() {

    if (!window.Square) {

        throw new Error(
            'Square SDK could not load. Check your internet connection.'
        );

    }

    if (
        !appId ||
        !locationId ||
        appId.includes('YOUR_') ||
        locationId.includes('YOUR_')
    ) {

        throw new Error(
            'Check Square Application ID and Location ID in config/square.php.'
        );

    }

    const payments = window.Square.payments(appId, locationId);

    const card = await payments.card();

    await card.attach('#card-container');

    checkoutForm.addEventListener('submit', async (event) => {

        event.preventDefault();

        if (!checkoutForm.reportValidity()) {
            return;
        }

        messageBox.style.display = 'none';

        button.disabled = true;

        buttonText.textContent = 'Processing securely...';

        try {

            const tokenResult = await card.tokenize();

            if (tokenResult.status !== 'OK') {

                throw new Error(
                    'Card verification failed. Please check your card details.'
                );

            }

            const data = new URLSearchParams();

            data.set('source_id', tokenResult.token);

            data.set(
                'full_name',
                document.getElementById('full_name').value.trim()
            );

            data.set(
                'email',
                document.getElementById('email').value.trim()
            );

            data.set(
                'phone',
                document.getElementById('phone').value.trim()
            );

            data.set(
                'booking_id',
                document.getElementById('booking_id').value.trim()
            );

            data.set('cart_checkout', '1');

            const response = await fetch('square-payment.php', {

                method: 'POST',

                headers: {
                    'Content-Type':
                        'application/x-www-form-urlencoded;charset=UTF-8',

                    'X-CSRF-Token': csrfToken
                },

                body: data.toString()

            });

            const result = await response.json();

            if (!response.ok || !result.success) {

                throw new Error(
                    result.message || 'Payment could not be completed.'
                );

            }

            const params = new URLSearchParams({
                payment_id: result.payment_id,
                order_id: result.order_id
            });

            window.location.href =
                'payment-success.php?' + params.toString();

        } catch (error) {

            showMessage(
                error.message || 'Something went wrong. Please try again.'
            );

            button.disabled = false;

            buttonText.textContent =
                'Pay $<?= number_format($grandTotal / 100, 2) ?> USD';

        }

    });

}

startCheckout().catch(error => {

    showMessage(
        error.message || 'Could not initialize Square payment fields.'
    );

});
</script>

</body>
</html>
