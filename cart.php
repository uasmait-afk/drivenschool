<?php
declare(strict_types=1);

session_start();

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Remove product
if (isset($_GET['remove'])) {
    $removeKey = (string) $_GET['remove'];

    if (isset($_SESSION['cart'][$removeKey])) {
        unset($_SESSION['cart'][$removeKey]);
    }

    header('Location: cart.php');
    exit;
}

// Update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {

    foreach ($_POST['quantity'] ?? [] as $key => $quantity) {

        if (isset($_SESSION['cart'][$key])) {

            $quantity = filter_var($quantity, FILTER_VALIDATE_INT);

            if ($quantity === false) {
                $quantity = 1;
            }

            $quantity = max(1, min(20, $quantity));

            $_SESSION['cart'][$key]['quantity'] = $quantity;
        }
    }

    header('Location: cart.php');
    exit;
}

$cart = $_SESSION['cart'];

$total = 0;
$totalItems = 0;

foreach ($cart as $item) {
    $price = (int) $item['price'];
    $quantity = (int) $item['quantity'];

    $total += $price * $quantity;
    $totalItems += $quantity;
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Shopping Cart | DriveN School</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
:root {
    --navy:#101d35;
    --deep:#091426;
    --gold:#f5a623;
    --bg:#f5f7fb;
}

body {
    background:var(--bg);
    font-family:Arial,sans-serif;
    color:#263449;
}

.navbar {
    background:var(--deep);
    padding:18px 0;
}

.brand {
    font-size:25px;
    font-weight:800;
    color:white;
    text-decoration:none;
}

.brand span {
    color:var(--gold);
}

.hero {
    background:linear-gradient(120deg,var(--deep),var(--navy));
    color:white;
    text-align:center;
    padding:55px 15px;
}

.hero h1 {
    font-weight:800;
}

.cart-card,.summary {
    background:white;
    border-radius:15px;
    padding:25px;
    box-shadow:0 8px 30px rgba(16,29,53,.07);
}

.package-icon {
    width:55px;
    height:55px;
    border-radius:12px;
    background:#fff4df;
    color:#d58b13;
    display:grid;
    place-items:center;
    font-size:25px;
    flex-shrink:0;
}

.package-name {
    color:var(--navy);
    font-weight:800;
}

.price {
    color:var(--navy);
    font-weight:800;
}

.btn-gold {
    background:var(--gold);
    color:var(--deep);
    border:0;
    padding:12px 18px;
    font-weight:800;
}

.btn-gold:hover {
    background:#ffbb4c;
    color:var(--deep);
}

.quantity {
    width:75px;
}

footer {
    background:var(--deep);
    color:#cbd3df;
    text-align:center;
    padding:22px;
}
</style>
</head>

<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="index.php" class="brand">
            Drive<span>N</span> School
        </a>

        <a href="index.php" class="text-white text-decoration-none">
            <i class="bi bi-house"></i> Home
        </a>
    </div>
</nav>

<section class="hero">
    <h1>Your Shopping Cart</h1>
    <p class="mb-0">Review your selected packages</p>
</section>

<section class="container py-5">

<?php if (!empty($cart)): ?>

<div class="row g-4">

    <div class="col-lg-8">

        <div class="cart-card">

            <div class="d-flex justify-content-between mb-4">
                <h4 class="package-name">Cart Items</h4>

                <span class="badge bg-success">
                    <?= $totalItems ?> Items
                </span>
            </div>

            <form method="POST" action="cart.php">

                <?php foreach ($cart as $key => $item): ?>

                <?php
                    $itemPrice = (int) $item['price'];
                    $itemQuantity = (int) $item['quantity'];
                    $lineTotal = $itemPrice * $itemQuantity;
                ?>

                <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 py-3 border-bottom">

                    <div class="package-icon">
                        <i class="bi bi-car-front-fill"></i>
                    </div>

                    <div class="flex-grow-1">

                        <h5 class="package-name mb-1">
                            <?= e($item['name']) ?>
                        </h5>

                        <small class="text-secondary">
                            Product Code: <?= e($item['product_code'] ?? '') ?>
                        </small>

                        <br>

                        <small class="text-secondary">
                            Price: $<?= number_format($itemPrice / 100, 2) ?>
                        </small>

                    </div>

                    <div>
                        <label class="small d-block">Quantity</label>

                        <input
                            class="form-control quantity"
                            type="number"
                            name="quantity[<?= e($key) ?>]"
                            value="<?= $itemQuantity ?>"
                            min="1"
                            max="20"
                            required
                        >
                    </div>

                    <div class="text-md-end">

                        <strong class="price">
                            $<?= number_format($lineTotal / 100, 2) ?>
                        </strong>

                        <br>

                        <a
                            href="cart.php?remove=<?= urlencode((string) $key) ?>"
                            class="text-danger small text-decoration-none"
                            onclick="return confirm('Remove this product?')"
                        >
                            <i class="bi bi-trash"></i> Remove
                        </a>

                    </div>

                </div>

                <?php endforeach; ?>

                <button
                    type="submit"
                    name="update_cart"
                    value="1"
                    class="btn btn-outline-secondary mt-4"
                >
                    <i class="bi bi-arrow-repeat"></i>
                    Update Cart
                </button>

            </form>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="summary">

            <h4 class="package-name mb-4">Order Summary</h4>

            <div class="d-flex justify-content-between mb-3">
                <span>Items</span>
                <strong><?= $totalItems ?></strong>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span>Subtotal</span>

                <strong>
                    $<?= number_format($total / 100, 2) ?>
                </strong>
            </div>

            <hr>

            <div class="d-flex justify-content-between mb-4">
                <strong>Total</strong>

                <h4 class="price">
                    $<?= number_format($total / 100, 2) ?>
                </h4>
            </div>

            <a href="checkout.php" class="btn btn-gold w-100">
                Proceed to Checkout
                <i class="bi bi-arrow-right"></i>
            </a>

        </div>

    </div>

</div>

<?php else: ?>

<div class="cart-card text-center py-5">

    <i class="bi bi-cart-x display-3 text-secondary"></i>

    <h3 class="package-name mt-3">
        Your Cart is Empty
    </h3>

    <p class="text-secondary">
        Choose a package to add it to your cart.
    </p>

    <a href="packages.php" class="btn btn-gold">
        Browse Packages
    </a>

</div>

<?php endif; ?>

</section>

<footer>
    &copy; <?= date('Y') ?> DriveN School. All Rights Reserved.
</footer>

</body>
</html>
