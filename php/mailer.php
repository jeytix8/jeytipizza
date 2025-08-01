<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'phpmailer/vendor/autoload.php';
include 'connect.php';

// Mailer Class
class Mailer{
    // Variables
    var $register_code;
    var $username = '';
    var $email = '';

    function __construct() {
        $this->register_code = rand(100000, 999999);
    }
    function setUsername($newUsername){
        $this->username = $newUsername;
    }
    function setEmail($newEmail){
        $this->email = $newEmail;
    }
        
    function sendMail(){
        try {
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'jayteex8@gmail.com';                     //SMTP username
            $mail->Password   = 'uddvcpomokaxrqvz';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('jayteex8@gmail.com', 'Jeytipizza');
            $mail->addAddress(  $this->email, $this->username);     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Register Account';
            $mail->Body    = 'Hi, '.$this->username.'! <br/><br/> To verify creating your account, put this code in your registration form. <br/> <strong>'.$this->register_code.'</strong>';
            $mail->AltBody = 'Registration Code:'.$this->register_code;
            
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}

// --------------------------------------------------------------------------
// Clicked register
if(isset($_POST['register'])){
    $reg_user = trim($_POST['username']);
    $reg_email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ? OR email = ?");
    $stmt->bind_param('ss', $reg_user, $reg_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        echo 'User exists!';
    }
    else{
        // Send Code
        $reg = new Mailer;
        $reg->setUsername($reg_user);
        $reg->setEmail($reg_email);
        $reg->sendMail();
        echo $reg->register_code;
    }

    $stmt->close();
}


// $sql = "INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("sss", $username, $password, $email);

// if($stmt->execute()){
//     echo 'success';
// }
// else{
//     echo 'Error: '.$stmt->error;
// }


