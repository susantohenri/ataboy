<?php defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP; -- UNCOMMENT FOR DEBUGGING

class Emails extends CI_Model
{

    function sendmail($subject, $body, $recipient)
    {
        

        $mail = new PHPMailer(true);

        try {
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; -- UNCOMMENT FOR DEBUGGING
            $mail->isSMTP();
            $mail->Host       = 'srv36.niagahoster.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'noreply@ecsms.sikembang.com';
            $mail->Password   = 'NppE%btE#8+Q';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;
            $mail->setFrom('noreply@ecsms.sikembang.com', 'NoReply');
            $mail->addAddress($recipient);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = strlen($body) > 0 ? $body : '&nbsp;';
            $mail->AltBody = '';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
