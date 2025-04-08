<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');


\Stripe\Stripe::setApiKey('sk_test_51R7EjiPumD0Cps480SxpOTZKg2VpDB7ZnupZ6KvUiqLidkw4dBbJLu7xM7psm6Wm8WHxZK152QRC9auMr8ewttyA00HtpYbrYn');

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$amount = 1499; // €14.99 in cents

try {
    $intent = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => 'eur',
        'automatic_payment_methods' => ['enabled' => true],
    ]);

    echo json_encode(['clientSecret' => $intent->client_secret]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
