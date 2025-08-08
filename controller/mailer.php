<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require '../assets/phpmailer/vendor/autoload.php';

// Mailer Class
class Mailer
{
    // Variables
    var $register_code;
    var $username = '';
    var $email = '';
    var $subject = '';
    var $body = '';
    var $altBody = '';

    function __construct()
    {
        $this->register_code = rand(100000, 999999);
    }
    function setUsername($newUsername)
    {
        $this->username = $newUsername;
    }
    function getUsername()
    {
        return $this->username;
    }

    function setEmail($newEmail)
    {
        $this->email = $newEmail;
    }
    function getEmail()
    {
        return $this->email;
    }

    function setSubject($newSubject)
    {
        $this->subject = $newSubject;
    }
    function getSubject()
    {
        return $this->subject;
    }

    function setBody($newBody)
    {
        $this->body = $newBody;
    }
    function getBody()
    {
        return $this->body;
    }

    function setAltBody($newAltBody)
    {
        $this->altBody = $newAltBody;
    }
    function getAltBody()
    {
        return $this->altBody;
    }
    function getRegisterCode()
    {
        return $this->register_code;
    }

    function sendMail()
    {
        try {
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'jayteex8@gmail.com';                     //SMTP username
            $mail->Password = 'uddvcpomokaxrqvz';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('jayteex8@gmail.com', 'Jeytipizza');
            $mail->addAddress($this->email, $this->username);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $this->getSubject();
            $mail->Body = $this->getBody();
            $mail->AltBody = $this->getAltBody();

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}
