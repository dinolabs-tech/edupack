<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

function sendEmail($recipientEmail, $recipientName, $subject, $body, $isHTML = true, $replyToEmail = '', $replyToName = '') {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'mail.dinolabstech.com'; // Configure this in a central config file later
        $mail->SMTPAuth   = true;
        $mail->Username   = 'enquiries@dinolabstech.com'; // Configure this in a central config file later
        $mail->Password   = 'Dinolabs@11';     // Configure this in a central config file later
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('enquiries@dinolabstech.com', 'Dinolabs Tech Services');
        $mail->addAddress($recipientEmail, $recipientName);

        if (!empty($replyToEmail)) {
            $mail->addReplyTo($replyToEmail, $replyToName);
        } else {
            $mail->addReplyTo('enquiries@dinolabstech.com', 'Dinolabs Tech Services');
        }

        $mail->isHTML($isHTML);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Email to {$recipientEmail} could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
