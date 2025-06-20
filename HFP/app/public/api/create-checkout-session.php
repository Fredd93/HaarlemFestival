<?php
session_start();
require_once '../../vendor/autoload.php'; 

header('Content-Type: application/json'); 

\Stripe\Stripe::setApiKey(
    'sk_test_51RP6DB2NUICtS7JXYdJHNUpjY4Jh04OUGlIyk2vWgyTlLLkgDxKvqT8tGch5bfcV9rD0txiSvzFM07N8kq3HmkYe00wNDycLpc'
);

$input = json_decode(file_get_contents('php://input'), true);

$items = isset($input['items']) ? $input['items'] : 0;

if (empty($items)) {
    http_response_code(400);
    echo json_encode(['message' => 'No items']);
    exit;
}

$lineItems = []; 

foreach ($items as $item) {
    if (
        !isset($item['Event_Name']) || empty($item['Event_Name']) ||
        !isset($item['Price']) || !is_numeric($item['Price'])
    ) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid item data', 'item' => $item]);
        exit;
    }
    $lineItems[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $item['Event_Name'],
            ],
            'unit_amount' => intval($item['Price'] * 100),
        ],
        'quantity' => 1,
    ];
}

try {
    $session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card', 'ideal', 'paypal'],
    'line_items' => $lineItems,
    'mode' => 'payment',
    'metadata' => [
        'user_id' => $_SESSION['user_id'] ?? 0
    ],
    'success_url' => 'https://floral-cruz-significance-discount.trycloudflare.com/paymentSuccess',
    'cancel_url' => 'https://floral-cruz-significance-discount.trycloudflare.com/',
]);

    echo json_encode(['sessionId' => $session->id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()]);
}
