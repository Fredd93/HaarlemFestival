<?php
require_once(__DIR__ . '/../models/OrderModel.php');
require_once(__DIR__ . '/../models/InvoiceModel.php');
require_once(__DIR__ . '/../api/utils/MailService.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');


header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'], $data['email'], $data['total_price'], $data['payment_method'])) {
    ResponseHelper::sendError("Missing fields", 400);
    exit;
}

$userId = (int)$data['user_id'];
$email = $data['email'];
$totalPrice = (int)$data['total_price'];
$paymentMethod = $data['payment_method'];

    try {
        $orderRes = apiPost("/api/orders", [
            "user_id" => $userId,
            "total_price" => $totalPrice,
            "payment_method" => $paymentMethod
        ]);
        $orderId = $orderRes['order_id'];
    
        $dueDate = date('Y-m-d', strtotime('+7 days'));
        $invoiceRes = apiPost("/api/invoices", [
            "order_id" => $orderId,
            "due_date" => $dueDate
        ]);
        $invoiceId = $invoiceRes['invoice_id'];
    
        // 3. Send mail with QR
        $mailService = new MailService();
        $mailService->sendInvoiceMailWithQR($email, $invoiceId, $orderId);

    ResponseHelper::sendJson([
        "message" => "Order and invoice created, QR sent via email.",
        "order_id" => $orderId,
        "invoice_id" => $invoiceId
    ]);
} catch (Exception $e) {
    error_log("Payment error: " . $e->getMessage());
    ResponseHelper::sendError("Server error: " . $e->getMessage(), 500);
}

function apiPost(string $endpoint, array $data): array {
    $url = "http://nginx" . $endpoint;


    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        CURLOPT_POSTFIELDS => json_encode($data)
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception("CURL error: " . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Add this debug log
    error_log("✅ API [$endpoint] responded with: $response");

    $json = json_decode($response, true);

    if ($httpCode >= 400 || !$json) {
        throw new Exception("API Error: " . ($json['error'] ?? "Unknown error. Raw: " . $response));
    }


    return $json;
}

