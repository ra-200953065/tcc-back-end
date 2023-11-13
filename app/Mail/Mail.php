<?php

namespace App\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public static function send(array $mailData)
    {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);

        try {
            $mail->CharSet = "UTF-8";
            $mail->Timeout = 30;
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port = env('MAIL_PORT');
            $mail->isHTML(true);

            if (isset($_FILES['emailAttachments'])) {
                for ($i = 0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }

            $mail->SetFrom(env('MAIL_FROM_ADDRESS'));
            $mail->addAddress($mailData['to']);
            $mail->Subject = $mailData['subject'];
            $mail->Body = $mailData['body'];

            if ($mail->send()) {
                return true;
            } else {
                return ['message' => $mail->ErrorInfo];
            }
        } catch (Exception $e) {
            // $mail->SmtpClose();
            return ['message' => 'Message could not be sent.'];
        }
    }
}
