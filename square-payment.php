<?php
declare(strict_types=1);

session_start();

header('Content-Type: application/json; charset=utf-8');

function respond(int $status, array $data): never
{
    http_response_code($status);
    echo json_encode($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    respond(405, [
        'success' => false,
        'message' => 'POST request required.'
    ]);
}

/*
|--------------------------------------------------------------------------
| CSRF verification
|--------------------------------------------------------------------------
*/

if (
    empty($_SESSION['payment_csrf']) ||
    !hash_equals(
        (string)$_SESSION['payment_csrf'],
        (string)($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '')
    )
) {
    respond(403, [
        'success' => false,
        'message' => 'Security token expired. Refresh checkout and try again.'
    ]);
}

/*
|--------------------------------------------------------------------------
| Receive checkout information
|--------------------------------------------------------------------------
*/

$sourceId = trim((string)($_POST['source_id'] ?? ''));

$fullName = trim((string)($_POST['full_name'] ?? ''));

$email = trim((string)($_POST['email'] ?? ''));

$phone = trim((string)($_POST['phone'] ?? ''));

$bookingIdRaw = trim((string)($_POST['booking_id'] ?? ''));

if ($sourceId === '' || strlen($sourceId) > 2000) {
    respond(422, [
        'success' => false,
        'message' => 'Invalid card payment token.'
    ]);
}

if (
    $fullName === '' ||
    strlen($fullName) > 150 ||
    preg_match('/[\x00-\x1F\x7F]/', $fullName)
) {
    respond(422, [
        'success' => false,
        'message' => 'Please enter a valid full name.'
    ]);
}

if (
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    strlen($email) > 150
) {
    respond(422, [
        'success' => false,
        'message' => 'Please enter a valid email address.'
    ]);
}

if (
    $phone === '' ||
    strlen($phone) > 30 ||
    !preg_match('/^[0-9+\-\s().]+$/', $phone)
) {
    respond(422, [
        'success' => false,
        'message' => 'Please enter a valid phone number.'
    ]);
}

if (($_POST['cart_checkout'] ?? '') !== '1') {
    respond(422, [
        'success' => false,
        'message' => 'Invalid checkout request.'
    ]);
}

/*
|--------------------------------------------------------------------------
| Optional booking ID
|--------------------------------------------------------------------------
*/

$bookingId = null;

if ($bookingIdRaw !== '') {

    if (
        !ctype_digit($bookingIdRaw) ||
        (int)$bookingIdRaw < 1
    ) {
        respond(422, [
            'success' => false,
            'message' => 'Invalid booking ID.'
        ]);
    }

    $bookingId = (int)$bookingIdRaw;
}

/*
|--------------------------------------------------------------------------
| Main payment process
|--------------------------------------------------------------------------
*/

try {

    require_once __DIR__ . '/config/db.php';

    $square = require __DIR__ . '/config/square.php';

    /*
    |--------------------------------------------------------------------------
    | Square credentials
    |--------------------------------------------------------------------------
    */

    foreach ([
        'application_id',
        'access_token',
        'location_id',
        'api_url',
        'api_version'
    ] as $requiredKey) {

        if (empty($square[$requiredKey])) {

            respond(503, [
                'success' => false,
                'message' => 'Square configuration is incomplete.'
            ]);

        }

    }

    if (
        str_contains($square['application_id'], 'YOUR_') ||
        str_contains($square['access_token'], 'YOUR_') ||
        str_contains($square['location_id'], 'YOUR_')
    ) {
        respond(503, [
            'success' => false,
            'message' => 'Square credentials are not configured.'
        ]);
    }

    if (!function_exists('curl_init')) {
        respond(500, [
            'success' => false,
            'message' => 'PHP cURL extension is not enabled.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Load and verify cart products from database
    |--------------------------------------------------------------------------
    */

    $cart = $_SESSION['cart'] ?? [];

    if (!is_array($cart) || empty($cart)) {
        respond(422, [
            'success' => false,
            'message' => 'Your shopping cart is empty.'
        ]);
    }

    $cartItems = [];
    $subtotalCents = 0;

    foreach ($cart as $key => $item) {

        $productId = (int)($item['product_id'] ?? $key);

        $quantity = (int)($item['quantity'] ?? 1);

        if (
            $productId < 1 ||
            $quantity < 1 ||
            $quantity > 20
        ) {
            respond(422, [
                'success' => false,
                'message' => 'Invalid cart product or quantity.'
            ]);
        }

        $productQuery = $pdo->prepare("
            SELECT id, product_code, product_name, price_cents
            FROM products
            WHERE id = ?
              AND is_active = 1
            LIMIT 1
        ");

        $productQuery->execute([$productId]);

        $product = $productQuery->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            respond(422, [
                'success' => false,
                'message' => 'A selected product is no longer available.'
            ]);
        }

        $price = (int)$product['price_cents'];

        if ($price < 1) {
            respond(422, [
                'success' => false,
                'message' => 'Invalid product price.'
            ]);
        }

        $lineTotal = $price * $quantity;

        $cartItems[] = [
            'product_id' => (int)$product['id'],
            'product_code' => $product['product_code'],
            'product_name' => $product['product_name'],
            'price' => $price,
            'quantity' => $quantity,
            'line_total' => $lineTotal
        ];

        $subtotalCents += $lineTotal;
    }

    if ($subtotalCents < 1) {
        respond(422, [
            'success' => false,
            'message' => 'Invalid order total.'
        ]);
    }

    $totalCents = $subtotalCents;

    /*
    |--------------------------------------------------------------------------
    | Verify optional booking
    |--------------------------------------------------------------------------
    */

    if ($bookingId !== null) {

        $bookingCheck = $pdo->prepare(
            'SELECT id FROM bookings WHERE id = ? LIMIT 1'
        );

        $bookingCheck->execute([$bookingId]);

        if (!$bookingCheck->fetchColumn()) {
            respond(404, [
                'success' => false,
                'message' => 'Booking not found.'
            ]);
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Reuse an existing unfinished order
    |--------------------------------------------------------------------------
    */

    $orderId = (int)($_SESSION['active_order_id'] ?? 0);

    $order = null;

    if ($orderId > 0) {

        $orderQuery = $pdo->prepare("
            SELECT *
            FROM orders
            WHERE id = ?
            LIMIT 1
        ");

        $orderQuery->execute([$orderId]);

        $order = $orderQuery->fetch(PDO::FETCH_ASSOC);

        if (
            !$order ||
            !in_array(
                $order['order_status'],
                ['pending', 'payment_pending'],
                true
            )
        ) {
            $order = null;
            $orderId = 0;

            unset(
                $_SESSION['active_order_id'],
                $_SESSION['square_attempt']
            );
        }

    }

    if ($order !== null) {

        if (
            $order['full_name'] !== $fullName ||
            $order['email'] !== $email ||
            $order['phone'] !== $phone ||
            (int)$order['total_cents'] !== $totalCents
        ) {
            respond(409, [
                'success' => false,
                'message' => 'Your existing order does not match this checkout. Please contact support before retrying.'
            ]);
        }

        /*
         * Do not silently change the contents of an existing order.
         */
        $existingItemsQuery = $pdo->prepare("
            SELECT product_id, quantity, unit_price_cents
            FROM order_items
            WHERE order_id = ?
            ORDER BY product_id
        ");

        $existingItemsQuery->execute([$orderId]);

        $existingItems = $existingItemsQuery->fetchAll(PDO::FETCH_ASSOC);

        $expectedItems = [];

        foreach ($cartItems as $cartItem) {
            $expectedItems[] = [
                'product_id' => $cartItem['product_id'],
                'quantity' => $cartItem['quantity'],
                'unit_price_cents' => $cartItem['price']
            ];
        }

        usort($expectedItems, fn($a, $b) =>
            $a['product_id'] <=> $b['product_id']
        );

        usort($existingItems, fn($a, $b) =>
            (int)$a['product_id'] <=> (int)$b['product_id']
        );

        $normalizedExisting = [];

        foreach ($existingItems as $existingItem) {
            $normalizedExisting[] = [
                'product_id' => (int)$existingItem['product_id'],
                'quantity' => (int)$existingItem['quantity'],
                'unit_price_cents' => (int)$existingItem['unit_price_cents']
            ];
        }

        if ($normalizedExisting !== $expectedItems) {
            respond(409, [
                'success' => false,
                'message' => 'Your cart has changed since this order was created. Please contact support before retrying.'
            ]);
        }

    } else {

        /*
        |--------------------------------------------------------------------------
        | Create new order and order items
        |--------------------------------------------------------------------------
        */

        $orderNumber = 'DS-' .
            date('YmdHis') . '-' .
            strtoupper(bin2hex(random_bytes(3)));

        $pdo->beginTransaction();

        try {

            $createOrder = $pdo->prepare("
                INSERT INTO orders
                (
                    order_number,
                    full_name,
                    email,
                    phone,
                    subtotal_cents,
                    total_cents,
                    currency,
                    order_status
                )
                VALUES (?, ?, ?, ?, ?, ?, 'USD', 'payment_pending')
            ");

            $createOrder->execute([
                $orderNumber,
                $fullName,
                $email,
                $phone,
                $subtotalCents,
                $totalCents
            ]);

            $orderId = (int)$pdo->lastInsertId();

            $createItem = $pdo->prepare("
                INSERT INTO order_items
                (
                    order_id,
                    product_id,
                    product_code,
                    product_name,
                    unit_price_cents,
                    quantity,
                    line_total_cents
                )
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            foreach ($cartItems as $cartItem) {

                $createItem->execute([
                    $orderId,
                    $cartItem['product_id'],
                    $cartItem['product_code'],
                    $cartItem['product_name'],
                    $cartItem['price'],
                    $cartItem['quantity'],
                    $cartItem['line_total']
                ]);

            }

            $pdo->commit();

            $_SESSION['active_order_id'] = $orderId;

        } catch (Throwable $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            throw $e;

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Protect against repeating an uncertain Square attempt
    |--------------------------------------------------------------------------
    */

    $attempt = $_SESSION['square_attempt'] ?? null;

    if (
        is_array($attempt) &&
        (int)($attempt['order_id'] ?? 0) === $orderId
    ) {

        if (
            !hash_equals(
                (string)$attempt['source_id'],
                $sourceId
            )
        ) {
            respond(409, [
                'success' => false,
                'message' => 'A previous payment attempt has an uncertain result. Please contact DriveN School before trying another card.'
            ]);
        }

        $idempotencyKey = $attempt['idempotency_key'];

    } else {

        $idempotencyKey = bin2hex(random_bytes(16));

        $_SESSION['square_attempt'] = [
            'order_id' => $orderId,
            'source_id' => $sourceId,
            'idempotency_key' => $idempotencyKey
        ];

    }

    /*
    |--------------------------------------------------------------------------
    | Send payment request to Square
    |--------------------------------------------------------------------------
    */

    $orderNumberQuery = $pdo->prepare(
        'SELECT order_number FROM orders WHERE id = ? LIMIT 1'
    );

    $orderNumberQuery->execute([$orderId]);

    $orderNumber = (string)$orderNumberQuery->fetchColumn();

    $payload = [
        'source_id' => $sourceId,

        'idempotency_key' => $idempotencyKey,

        'amount_money' => [
            'amount' => $totalCents,
            'currency' => 'USD'
        ],

        'location_id' => $square['location_id'],

        'autocomplete' => true,

        'reference_id' => $orderNumber,

        'note' => 'DriveN School Order ' . $orderNumber
    ];

    $ch = curl_init(
        rtrim($square['api_url'], '/') . '/v2/payments'
    );

    curl_setopt_array($ch, [

        CURLOPT_POST => true,

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_CONNECTTIMEOUT => 10,

        CURLOPT_TIMEOUT => 30,

        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $square['access_token'],
            'Content-Type: application/json',
            'Square-Version: ' . $square['api_version']
        ],

        CURLOPT_POSTFIELDS => json_encode(
            $payload,
            JSON_THROW_ON_ERROR
        )

    ]);

    $responseBody = curl_exec($ch);

    $curlError = curl_error($ch);

    $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($responseBody === false) {

        error_log('Square cURL error: ' . $curlError);

        /*
         * Keep the same attempt key because the result is uncertain.
         */
        respond(502, [
            'success' => false,
            'message' => 'Square connection timed out. The payment result is uncertain. Please contact support before trying again.'
        ]);

    }

    $result = json_decode($responseBody, true);

    if (!is_array($result)) {

        error_log('Invalid Square response: ' . substr($responseBody, 0, 2000));

        respond(502, [
            'success' => false,
            'message' => 'Unexpected response from Square. Please contact support.'
        ]);

    }

    $payment = $result['payment'] ?? [];

    $paymentStatus = $payment['status'] ?? '';

    $paymentId = $payment['id'] ?? null;

    /*
    |--------------------------------------------------------------------------
    | Confirm completed payment
    |--------------------------------------------------------------------------
    */

    if (
        $httpCode >= 200 &&
        $httpCode < 300 &&
        $paymentStatus === 'COMPLETED' &&
        is_string($paymentId) &&
        $paymentId !== ''
    ) {

        $pdo->beginTransaction();

        try {

            /*
             * Avoid saving the same Square payment twice.
             */
            $existingPayment = $pdo->prepare("
                SELECT id
                FROM payments
                WHERE square_payment_id = ?
                LIMIT 1
            ");

            $existingPayment->execute([$paymentId]);

            if (!$existingPayment->fetchColumn()) {

                $savePayment = $pdo->prepare("
                    INSERT INTO payments
                    (
                        order_id,
                        booking_id,
                        square_payment_id,
                        amount_cents,
                        currency,
                        payment_status,
                        payment_method
                    )
                    VALUES (?, ?, ?, ?, 'USD', 'completed', 'square')
                ");

                $savePayment->execute([
                    $orderId,
                    $bookingId,
                    $paymentId,
                    $totalCents
                ]);

            }

            /*
             * Mark the order as paid only after Square confirms completion.
             */
            $updateOrder = $pdo->prepare("
                UPDATE orders
                SET order_status = 'paid'
                WHERE id = ?
            ");

            $updateOrder->execute([$orderId]);

            $pdo->commit();

        } catch (Throwable $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            throw $e;

        }

        /*
         * Clear cart only after successful payment and database save.
         */
        unset(
            $_SESSION['cart'],
            $_SESSION['active_order_id'],
            $_SESSION['square_attempt']
        );

        respond(200, [
            'success' => true,
            'message' => 'Payment completed successfully.',
            'payment_id' => $paymentId,
            'order_id' => $orderId,
            'order_number' => $orderNumber,
            'amount_cents' => $totalCents,
            'currency' => 'USD'
        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Handle a definite Square rejection
    |--------------------------------------------------------------------------
    */

    error_log(
        'Square payment response: ' .
        substr($responseBody, 0, 3000)
    );

    /*
     * A definite HTTP rejection allows a new payment attempt.
     * Keep the attempt if Square returned a successful HTTP response
     * but the payment is not confirmed COMPLETED.
     */
    if ($httpCode >= 400 && $httpCode < 500) {
        unset($_SESSION['square_attempt']);
    }

    respond(402, [
        'success' => false,
        'message' => 'Payment was not completed. Please check your payment details or contact support.'
    ]);

} catch (Throwable $e) {

    error_log(
        'DriveN payment error: ' . $e->getMessage()
    );

    respond(500, [
        'success' => false,
        'message' => 'A server error occurred. Please check the server log.'
    ]);

}
