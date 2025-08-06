<?php
include 'mailer.php';
include 'connect.php';

// --------------------------------------------------------------------------
// Clicked register
if (isset($_POST['register'])) {
    $reg_user = trim($_POST['username']);
    $reg_email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ? OR email = ?");
    $stmt->bind_param('ss', $reg_user, $reg_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo 'exists';
    } else {
        // Send Code
        $reg = new Mailer;
        $reg->setUsername($reg_user);
        $reg->setEmail($reg_email);
        $reg->setSubject('Register Account'); 
        $reg->setBody('Hi, <strong>' . $reg->getUsername() . '</strong>! <br/><br/> To verify creating your account, put this code in your registration form. <br/><br/> <strong>' . $reg->getRegisterCode() . '</strong>');
        $reg->setAltBody('Registration Code: ' . $reg->getRegisterCode());

        $reg->sendMail();

        $user = [
            "username" => $reg_user,
            "email" => $reg_email,
            "password" => $password,
            "register_code" => $reg->getRegisterCode()
        ];

        echo json_encode($user);
    }

    $stmt->close();
}

// Verified Register
if (isset($_POST['verified_code'])) {
    $insertUn = trim($_POST['username']);
    $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $insertPw = $hashedPassword;
    $insertEmail = trim($_POST['email']);

    $stmt = $conn->prepare("INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $insertUn, $insertPw, $insertEmail);

    if ($stmt->execute()) {
        echo 'Register successful!';
    } else {
        echo 'Error: ' . $stmt->error;
    }
}


// Forgot Send Code
if (isset($_POST['enteredForgotUser'])) {
    $enteredUser = trim($_POST['enteredForgotUser']);

    $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ? OR email = ?");
    $stmt->bind_param('ss', $enteredUser, $enteredUser);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $email = $row['email'];

        // Send Code
        $forgot = new Mailer;
        $forgot->setUsername($username);
        $forgot->setEmail($email);
        $forgot->setSubject('Forgot Password Verification Code'); 
        $forgot->setBody('Hi, <strong>' . $username . '</strong>! <br/><br/> To verify creating your account, put this code in your registration form. <br/><br/> <strong>' . $forgot->getRegisterCode() . '</strong>');
        $forgot->setAltBody('Registration Code: ' . $forgot->getRegisterCode());

        $forgot->sendMail();

        $verifyForgot = [
            "user" => $enteredUser,
            "forgot_code" => $forgot->getRegisterCode()
        ];

        echo json_encode($verifyForgot);
    } else {
        echo 'User does not exists!';
    }

    $stmt->close();
}

if (isset($_POST['forgot_verified_user']) && isset($_POST['newPass'])) {
    $verifiedUser = trim($_POST['forgot_verified_user']);
    $hashedNewPassword = password_hash($_POST['newPass'], PASSWORD_BCRYPT);
    $updatedPw = $hashedNewPassword;

    $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ? OR email = ?");
    $stmt->bind_param('ss', $verifiedUser, $verifiedUser);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $usernameCheck = $row['username'];
        $emailCheck = $row['email'];

        $updateStmt = $conn->prepare("UPDATE accounts SET password = ? WHERE username = ? AND email = ?");
        $updateStmt->bind_param('sss', $hashedNewPassword, $usernameCheck, $emailCheck);
        if ($updateStmt->execute()){
            echo 'updated';
        }
        else{
            echo 'Update failed!';
        }
    } 
    else {
        echo 'Multiple account detected! ' . $result->num_rows;
    }

    $stmt->close();
}

