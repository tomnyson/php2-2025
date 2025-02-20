<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
class Utils {
    public static function send($to = 'tabletkindfire@gmail.com', $from = 'tabletkindfire@gmail.com', $sublect = 'notfication', $content = '')
    {
        try {
            $mail = new PHPMailer();
            // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $_ENV['EMAIL_HOST'];  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $_ENV['EMAIL_USERNAME'];                 // SMTP username
            $mail->Password = $_ENV['EMAIL_PASSWORD'];                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $_ENV;                                    // TCP port to connect to
            $mail->CharSet = 'UTF-8';
            //Recipients
            $mail->setFrom($to, 'tomnysontech shop');
            $mail->addAddress($from);               // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $sublect;
            $mail->Body    = $content;
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
}