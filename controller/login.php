<?php
include 'connect.php';

session_start();

$user = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM accounts WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $user, $user);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows){
    $row = $result->fetch_assoc();

    if(password_verify($password, $row['password'])){
        $_SESSION['userID'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['type'] = $row['type'];
        
        echo 'verified';
    }
    else{
        echo 'Incorrect password!';
    }
}
else{
    echo 'User not found.';
}
?>