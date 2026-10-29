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
    respond(405, ['success' => false, 'message' => 'POST request required.']);
}

if (
    empty($_SESSION['payment_csrf']) ||
    !hash_equals(
        $_SESSION['payment_csrf'],
        (string)($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '')
    )
) {
    respond(403, ['success' => false, 'message' => 'Security token expired. Refresh checkout and try again.']);
}

$sourceId = trim((string)($_POST['source_id'] ?? ''));
$packageKey = trim((string)($_POST['package'] ?? ''));
$bookingIdRaw = trim((string)($_POST['booking_id'] ?? ''));

if ($sourceId === '' || strlen($sourceId) > 2000) {
    respond(422, ['success' => false, 'message' => 'Please enter valid card details.']);
}

/*
 * Server-side prices.
 * Update these amounts to match your final package pricing.
 */
$packages = [
    'basic'      => ['name' => 'Basic Package', 'amount' => 14900],
    'standard'   => ['name' => 'Standard Package', 'amount' => 27900],
    'individual' => ['name' => 'Individual Lesson', 'amount' => 5900],
    'custom'     => ['name' => 'Custom Package', 'amount' => 39900],
];

if (!isset($packages[$packageKey])) {
    respond(422, ['success' => false, 'message' => 'Please select a valid package.']);
}

$bookingId = null;

if ($bookingIdRaw !== '') {
    if (!ctype_digit($bookingIdRaw) || (int)$bookingIdRaw < 1) {
        respond(422, ['success' => false, 'message' => 'Invalid booking ID.']);
    }
    $bookingId = (int)$bookingIdRaw;
}

try {
    $square = require __DIR__ . '/config/square.php';

    if (
        str_contains($square['application_id'], 'YOUR_') ||
        str_contains($square['access_token'], 'YOUR_') ||
        str_contains($square['location_id'], 'YOUR_')
    ) {
        respond(503, ['success' => false, 'message' => 'Square Sandbox credentials are not configured yet.']);
    }

    require __DIR__ . '/config/db.php';

    // If a booking ID is supplied, confirm that it exists.
    if ($bookingId !== null) {
        $check = $pdo->prepare('SELECT id FROM bookings WHERE id = ? LIMIT 1');
        $check->execute([$bookingId]);

        if (!$check->fetchColumn()) {
            respond(404, ['success' => false, 'message' => 'Booking not found.']);
        }
    }

    if (!function_exists('curl_init')) {
        respond(500, ['success' => false, 'message' => 'PHP cURL extension is not enabled.']);
    }

    $amountCents = $packages[$packageKey]['amount'];

    $payload = [
        'source_id' => $sourceId,
        'idempotency_key' => bin2hex(random_bytes(16)),
        'amount_money' => [
            'amount' => $amountCents,
            'currency' => 'USD',
        ],
        'location_id' => $square['location_id'],
        'autocomplete' => true,
        'note' => 'DriveN School - ' . $packages[$packageKey]['name'],
    ];

    if ($bookingId !== null) {
        $payload['reference_id'] = (string)$bookingId;
    }

    $ch = curl_init(rtrim($square['api_url'], '/') . '/v2/payments');

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $square['access_token'],
            'Content-Type: application/json',
            'Square-Version: ' . $square['api_version'],
        ],
        CURLOPT_POSTFIELDS => json_encode($payload, JSON_THROW_ON_ERROR),
    ]);

    $responseBody = curl_exec($ch);
    $curlError = curl_error($ch);
    $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($responseBody === false) {
        error_log('Square cURL error: ' . $curlError);
        respond(502, ['success' => false, 'message' => 'Could not connect to Square. Please try again.']);
    }

    $result = json_decode($responseBody, true);

    if (!is_array($result)) {
        respond(502, ['success' => false, 'message' => 'Unexpected response from Square.']);
    }

    $payment = $result['payment'] ?? [];
    $paymentStatus = $payment['status'] ?? '';
    $paymentId = $payment['id'] ?? null;

    // A successful HTTP response alone is not sufficient.
    if ($httpCode >= 200 && $httpCode < 300 &&
        $paymentStatus === 'COMPLETED' && is_string($paymentId)) {

        $save = $pdo->prepare(
            'INSERT INTO payments
             (booking_id, square_payment_id, amount_cents, currency, payment_status)
             VALUES (?, ?, ?, ?, ?)'
        );

        $save->execute([
            $bookingId,
            $paymentId,
            $amountCents,
            'USD',
            'completed',
        ]);

        respond(200, [
            'success' => true,
            'message' => 'Payment completed successfully.',
            'payment_id' => $paymentId,
            'package' => $packages[$packageKey]['name'],
            'amount_cents' => $amountCents,
            'currency' => 'USD',
        ]);
    }

    // Do not send internal API errors or secret details to the browser.
    error_log('Square payment response: ' . substr($responseBody, 0, 3000));

    respond(402, [
        'success' => false,
        'message' => 'Payment was not completed. Please check your payment details and try again.',
    ]);

} catch (Throwable $e) {
    error_log('DriveN payment error: ' . $e->getMessage());

    respond(500, [
        'success' => false,
        'message' => 'A server error occurred. Please check the server log.',
    ]);
}
