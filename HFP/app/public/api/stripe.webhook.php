<?php
require_once '../../vendor/autoload.php';
require_once(__DIR__ . '/../models/OrderModel.php');
require_once(__DIR__ . '/../models/InvoiceModel.php');
require_once(__DIR__ . '/../api/utils/MailService.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

\Stripe\Stripe::setApiKey('sk_test_51RP6DB2NUICtS7JXYdJHNUpjY4Jh04OUGlIyk2vWgyTlLLkgDxKvqT8tGch5bfcV9rD0txiSvzFM07N8kq3HmkYe00wNDycLpc'); // secret key

$endpointSecret = 'whsec_CZrYnDIWLrrH22t44htqJWyuzSZfWRBM';

$payload = @file_get_contents("php://input");
$sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"] ?? '';
$event = null;


try {
    $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpointSecret);
} catch(\UnexpectedValueException $e) {
    http_response_code(400);
    exit("❌ Invalid payload");
} catch(\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400);
    exit("❌ Invalid signature");
}

if ($event->type === 'checkout.session.completed') {
    $session = $event->data->object;

    // Get user data from metadata
    $userId = ($session->metadata->user_id ?? 0);
    $email = $session->customer_details->email ?? null;
    $totalPrice = isset($session->amount_total) ? ($session->amount_total / 100) : 0; // Convert cents to EUR
    $charge = $paymentIntent->charges->data[0] ?? null;

    // 1. Get PaymentIntent ID from session
    $paymentIntentId = $session->payment_intent ?? null;

    // 2. Retrieve PaymentIntent from Stripe
    $paymentIntent = \Stripe\PaymentIntent::retrieve(
        $paymentIntentId,
        ['expand' => ['charges']]
    );

    $paymentMethod = null;
    $charge = null;

    if ($paymentIntent && isset($paymentIntent->charges->data[0])) {
        $charge = $paymentIntent->charges->data[0];
        $paymentMethod = $charge->payment_method_details->type ?? null;
    } elseif ($paymentIntent && isset($paymentIntent->latest_charge)) {
        $charge = \Stripe\Charge::retrieve($paymentIntent->latest_charge);
        $paymentMethod = $charge->payment_method_details->type ?? null;
    }

        try {
            $orderRes = json_decode(file_get_contents("https://guild-howard-declined-fiber.trycloudflare.com/api/orders/create", false, stream_context_create([
                'http' => [
                    'method'  => 'POST',
                    'header'  => "Content-Type: application/json\r\n",
                    'content' => json_encode([
                        "user_id" => $userId,
                        "total_price" => $totalPrice,
                        "payment_method" => $paymentMethod
                    ])
                ]
            ])), true);

            error_log("✅ Order response: " . json_encode($orderRes));
            if ($orderRes === null) {
                error_log("Order API call failed: " . print_r(error_get_last(), true));
            }
            $orderId = $orderRes['order_id'];

            $dueDate = date('Y-m-d', strtotime('+7 days'));
            $invoiceRes = json_decode(file_get_contents("https://guild-howard-declined-fiber.trycloudflare.com/api/invoices", false, stream_context_create([
                'http' => [
                    'method'  => 'POST',
                    'header'  => "Content-Type: application/json\r\n",
                    'content' => json_encode([
                        "order_id" => $orderId,
                        "due_date" => $dueDate
                    ])
                ]
            ])), true);

            $invoiceId = $invoiceRes['invoice_id'];

            $mailService = new MailService();
            $mailService->sendInvoiceMailWithQR($email, $invoiceId, $orderId);

            http_response_code(200);
        } catch (Exception $e) {
            error_log("Webhook error: " . $e->getMessage());
            http_response_code(500);
        }

}