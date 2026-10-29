<?php
declare(strict_types=1);
session_start();

$square = require __DIR__ . '/config/square.php';

if (empty($_SESSION['payment_csrf'])) {
    $_SESSION['payment_csrf'] = bin2hex(random_bytes(32));
}

$csrf = $_SESSION['payment_csrf'];
$appId = $square['application_id'];
$locationId = $square['location_id'];
$isSandbox = ($square['environment'] === 'sandbox');
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
.navbar { background: var(--navy-deep); }
.brand { color: white; font-weight: 800; letter-spacing: .3px; }
.brand span { color: var(--gold); }
.checkout-wrap { max-width: 1050px; margin: 55px auto; }
.checkout-card {
    background: white; border-radius: 22px; overflow: hidden;
    box-shadow: 0 20px 55px rgba(16,29,53,.09);
}
.checkout-main { padding: 35px; }
.summary {
    height: 100%; padding: 35px; color: white;
    background: linear-gradient(145deg,var(--navy),var(--navy-deep));
}
.eyebrow {
    color: var(--gold); font-weight: 800; text-transform: uppercase;
    letter-spacing: 1.5px; font-size: .76rem;
}
.form-control, .form-select {
    min-height: 49px; border-radius: 10px; border-color: #dce3ee;
}
.form-control:focus, .form-select:focus {
    border-color: var(--blue); box-shadow: 0 0 0 .2rem #2878f020;
}
#card-container {
    min-height: 55px; padding: 13px; border: 1px solid #dce3ee;
    border-radius: 10px; background: #fff;
}
.pay-btn {
    background: var(--gold); color: var(--navy-deep); border: 0;
    border-radius: 12px; padding: 15px; font-weight: 800;
}
.pay-btn:hover { background: var(--gold-hover); }
.pay-btn:disabled { opacity: .6; }
.amount { color: var(--gold); font-size: 2.2rem; font-weight: 800; }
#message { display: none; }
@media(max-width:767px) {
    .checkout-wrap { margin: 25px 12px; }
    .checkout-main, .summary { padding: 25px; }
}
</style>
</head>
<body>
<nav class="navbar py-3">
    <div class="container">
        <a class="navbar-brand brand" href="index.php">Drive<span>N</span> School</a>
        <span class="text-white small"><i class="bi bi-shield-lock"></i> Secure Checkout</span>
    </div>
</nav>

<main class="checkout-wrap">
    <div class="mb-4">
        <div class="eyebrow">Almost there</div>
        <h1 class="fw-bold mt-2">Complete your payment</h1>
        <p class="text-secondary mb-0">Choose your package and pay securely using Square.</p>
    </div>

    <?php if ($isSandbox): ?>
    <div class="alert alert-warning">
        <strong>Sandbox testing mode:</strong> no real payment should be taken.
    </div>
    <?php endif; ?>

    <div class="checkout-card">
        <div class="row g-0">
            <section class="col-lg-7 checkout-main">
                <h4 class="fw-bold mb-4">Payment details</h4>

                <div id="message" class="alert" role="alert"></div>

                <form id="checkout-form">
                    <label class="form-label fw-semibold" for="package">Select package</label>
                    <select class="form-select mb-3" id="package" name="package" required>
                        <option value="basic" data-price="149">$149 — Basic Package</option>
                        <option value="standard" data-price="279" selected>$279 — Standard Package</option>
                        <option value="individual" data-price="59">$59 — Individual Lesson</option>
                        <option value="custom" data-price="399">$399 — Custom Package</option>
                    </select>

                    <label class="form-label fw-semibold" for="booking_id">
                        Booking ID <span class="text-secondary fw-normal">(optional)</span>
                    </label>
                    <input class="form-control mb-3" type="number" min="1"
                           id="booking_id" name="booking_id"
                           placeholder="Enter your existing booking ID">

                    <label class="form-label fw-semibold">Card details</label>
                    <div id="card-container"></div>
                    <div class="form-text mb-4">
                        Your card details are handled by Square's secure payment fields.
                    </div>

                    <button class="btn pay-btn w-100" id="pay-button" type="submit">
                        <i class="bi bi-lock-fill me-2"></i>
                        <span id="button-text">Pay $279.00 USD</span>
                    </button>

                    <p class="text-secondary small text-center mt-3 mb-0">
                        <i class="bi bi-shield-check"></i>
                        Secure checkout powered by Square
                    </p>
                </form>
            </section>

            <aside class="col-lg-5">
                <div class="summary">
                    <div class="eyebrow">Your order</div>
                    <h3 class="fw-bold mt-2" id="summary-name">Standard Package</h3>
                    <p class="text-white-50">DriveN School driving lessons</p>
                    <hr class="border-secondary my-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-white-50">Package price</span>
                        <span id="summary-price">$279.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-white-50">Processing</span>
                        <span>Secure via Square</span>
                    </div>
                    <hr class="border-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Total</span>
                        <span class="amount" id="summary-total">$279</span>
                    </div>
                    <div class="mt-5 small text-white-50">
                        <i class="bi bi-info-circle me-1"></i>
                        The final amount is validated on the server.
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>

<script>
const appId = <?= json_encode($appId) ?>;
const locationId = <?= json_encode($locationId) ?>;
const csrfToken = <?= json_encode($csrf) ?>;

const packageSelect = document.getElementById('package');
const button = document.getElementById('pay-button');
const buttonText = document.getElementById('button-text');
const messageBox = document.getElementById('message');

const packageNames = {
    basic: 'Basic Package',
    standard: 'Standard Package',
    individual: 'Individual Lesson',
    custom: 'Custom Package'
};

function updatePrice() {
    const option = packageSelect.selectedOptions[0];
    const price = Number(option.dataset.price);
    document.getElementById('summary-name').textContent =
        packageNames[packageSelect.value];
    document.getElementById('summary-price').textContent =
        '$' + price.toFixed(2);
    document.getElementById('summary-total').textContent =
        '$' + price.toFixed(2);
    buttonText.textContent = 'Pay $' + price.toFixed(2) + ' USD';
}

packageSelect.addEventListener('change', updatePrice);

function showMessage(text, success = false) {
    messageBox.style.display = 'block';
    messageBox.className = 'alert ' + (success ? 'alert-success' : 'alert-danger');
    messageBox.textContent = text;
}

async function startCheckout() {
    if (!window.Square) {
        throw new Error('Square SDK could not load. Check your internet connection.');
    }
    if (appId.includes('YOUR_') || locationId.includes('YOUR_')) {
        throw new Error('Add your Square Sandbox Application ID and Location ID in config/square.php first.');
    }

    const payments = window.Square.payments(appId, locationId);
    const card = await payments.card();
    await card.attach('#card-container');

    document.getElementById('checkout-form').addEventListener('submit', async (event) => {
        event.preventDefault();
        messageBox.style.display = 'none';
        button.disabled = true;
        buttonText.textContent = 'Processing securely...';

        try {
            const tokenResult = await card.tokenize();

            if (tokenResult.status !== 'OK') {
                throw new Error('Card verification failed. Please check your card details.');
            }

            const data = new URLSearchParams();
            data.set('source_id', tokenResult.token);
            data.set('package', packageSelect.value);
            data.set('booking_id', document.getElementById('booking_id').value);

            const response = await fetch('square-payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                    'X-CSRF-Token': csrfToken
                },
                body: data.toString()
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Payment could not be completed.');
            }

            // Redirect only after backend confirms COMPLETED status.
            const params = new URLSearchParams({
                payment_id: result.payment_id
            });
            window.location.href = 'payment-success.php?' + params.toString();

        } catch (error) {
            showMessage(error.message || 'Something went wrong. Please try again.');
            button.disabled = false;
            updatePrice();
        }
    });
}

startCheckout().catch(error => {
    showMessage(error.message || 'Could not initialize Square payment fields.');
});
</script>
</body>
</html>
