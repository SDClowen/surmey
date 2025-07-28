<?php
namespace App\Helpers;

use Core\Config;
use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

class Mail
{
    public static function send($title, array $emails, $content)
    {
        $config =  (object)require_once(APP_DIR."/config/mailer.php");

        $mail = new PHPMailer(true);

        try {
            #$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = $config->host;
            $mail->Port = $config->port;
            $mail->SMTPAuth = $config->smtpauth;
            $mail->Username = $config->username;
            $mail->Password = $config->password;
            #Enable implicit TLS encryption
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            //Recipients
            $mail->setFrom($config->username, Config::get()->title." - ".$title);
            
            foreach($emails as $email)
                $mail->addAddress($email);
            
            $mail->CharSet = "utf-8";

            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = $title;
            $mail->Body = $content;
            $mail->send();
            
            return true;

        } catch (\Exception $e) {
            #error_log("Mailer Error: {$mail->ErrorInfo}");
        }

        return false;
    }
}