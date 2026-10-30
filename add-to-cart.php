<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/config/db.php';

// Get product code from URL
$productCode = '';

if (isset($_GET['package'])) {
    $productCode = trim((string) $_GET['package']);
} elseif (isset($_GET['service'])) {
    $productCode = trim((string) $_GET['service']);
}

// Validate product code
if ($productCode === '') {
    header('Location: index.php');
    exit;
}

try {
    // Find active product from database
    $stmt = $pdo->prepare("
        SELECT id, product_code, product_name, price_cents
        FROM products
        WHERE product_code = :product_code
          AND is_active = 1
        LIMIT 1
    ");

    $stmt->execute([
        'product_code' => $productCode
    ]);

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        header('Location: index.php');
        exit;
    }

    // Initialize cart
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $cartKey = (string) $product['id'];

    // Add quantity if product already exists
    if (isset($_SESSION['cart'][$cartKey])) {
        $_SESSION['cart'][$cartKey]['quantity']++;
    } else {
        $_SESSION['cart'][$cartKey] = [
            'product_id' => (int) $product['id'],
            'product_code' => $product['product_code'],
            'name' => $product['product_name'],
            'price' => (int) $product['price_cents'],
            'quantity' => 1
        ];
    }

    header('Location: cart.php');
    exit;

} catch (PDOException $e) {
    error_log('Add to cart error: ' . $e->getMessage());

    http_response_code(500);
    echo 'Something went wrong. Please try again later.';
    exit;
}
