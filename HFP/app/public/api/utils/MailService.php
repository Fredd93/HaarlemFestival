<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class MailService {
    public function sendInvoiceMailWithQR($email, $invoiceId, $orderId) {
        $mail = new PHPMailer(true);
        $qrContent = "https://yourdomain.com/api/scan-invoice?invoice_id={$invoiceId}";
        $qrResult = Builder::create()
            ->writer(new PngWriter())
            ->data($qrContent)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->build();

        $qrImagePath = __DIR__ . "/../../temp_qr/invoice_{$invoiceId}.png";
        $qrResult->saveToFile($qrImagePath);

        $subject = "Your Invoice & QR Code";
        $message = "<p>Thank you for your order. Scan the QR code below at the entrance:</p>";
        $message .= "<img src='cid:qr_code'>";

        $headers = [
            "MIME-Version: 1.0",
            "Content-type:text/html;charset=UTF-8",
            "From: no-reply@yourdomain.com"
        ];

        $mail->Host = 'localhost';
        $mail->Port = 1025;
        $mail->SMTPAuth = false;
        $mail->SMTPSecure = false; 


        $mail->setFrom("no-reply@haarlemfest.local", "Haarlem Festival");
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AddEmbeddedImage($qrImagePath, 'qr_code');

        $mail->send();
    }
}

?>