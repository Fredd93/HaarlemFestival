<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeModeMargin;
use Endroid\QrCode\RoundBlockSizeMode;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Writer\PngWriter;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {
    public function sendInvoiceMailWithQR($email, $invoiceId, $orderId) {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2; // or 3 for more detail
        $mail->Debugoutput = 'error_log'; // Log to PHP error log       

        try {

            // $url = `https://localhost/api/orders/` . $orderId;
            // $data = makeApiRequest($url);
            // $url = `https://localhost/api/personalProgram` . $data->User_Id;
            // $data = makeApiRequest($url);
            // foreach ($data as $item) {
            //     // Prepare QR content
            //     $qrContent = "https://localhost.com/api/qr?programID={$item->Program_Id}";

            //     // Configure QR code
            //     $qrCode = new QrCode(
            //         data: $qrContent,
            //         encoding: new Encoding('UTF-8'),
            //         errorCorrectionLevel: ErrorCorrectionLevel::Low,
            //         size: 300,
            //         margin: 10,
            //         roundBlockSizeMode: RoundBlockSizeMode::Margin,
            //         foregroundColor: new Color(0, 0, 0),
            //         backgroundColor: new Color(255, 255, 255)
            //     );
            //     // Write QR code
            //     $result = $writer->write($qrCode);

            //     // Save QR image
            //     $qrImagePath = __DIR__ . "/../../../temp_qr/program_{$item->Program_Id}.png";
            //     $result->saveToFile($qrImagePath);

            //     $message .= "<img src='cid:qr_code'>";
            // }
            // Prepare QR content
            $qrContent = "https://localhost.com/api/scan-invoice?invoice_id={$invoiceId}";

            // Configure QR code
            $qrCode = new QrCode(
                data: $qrContent,
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::Low,
                size: 300,
                margin: 10,
                roundBlockSizeMode: RoundBlockSizeMode::Margin,
                foregroundColor: new Color(0, 0, 0),
                backgroundColor: new Color(255, 255, 255)
            );
            
            // Write QR code
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            // Save QR image
            $qrImagePath = __DIR__ . "/../../../temp_qr/invoice_{$invoiceId}.png";
            $result->saveToFile($qrImagePath);

            // Email content
            $subject = "Your Invoice & QR Code";
            $message = "<p>Thank you for your order. Scan the QR code below at the entrance:</p>";
            $message .= "<img src='cid:qr_code'>";

            //Configure and send email
            $mail->isSMTP();
            $mail->Host = 'mailhog';
            $mail->Port = 1025;
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = false;

            $mail->setFrom("no-reply@haarlemfest.local", "Haarlem Festival");
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AddEmbeddedImage($qrImagePath, 'qr_code');
            error_log("Mail about to be sent");
            try {
                $mail->send();
            } catch (Exception $e) {
                error_log("❌ Mail sending failed: " . $mail->ErrorInfo);
            }


            // Cleanup
            unlink($qrImagePath);

        } catch (Exception $e) {
            error_log("Mail could not be sent. PHPMailer Error: {$mail->ErrorInfo}");
        }
    }
    public function makeApiRequest($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }
}
?>
