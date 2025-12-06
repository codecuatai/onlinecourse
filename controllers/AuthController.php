<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Yêu cầu các Model cần thiết
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        // Khởi tạo User Model để tương tác với CSDL
        $this->userModel = new User();
    }
    public function sendMailForgotPassword($emailTo, $content)
    {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'mynicktai1@gmail.com';                     //SMTP username
            $mail->Password   = 'rydyaaqnbuvhlhxq';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('mynicktai1@gmail.com', 'Online Courses Group 3');
            $mail->addAddress($emailTo);     //Add a recipient

            //Content
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Quên Mật Khẩu Tài Khoản Online Courses Group 3";
            $mail->Body    = $content;

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
