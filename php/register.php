<?php
include 'connect.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $password, $email);

if($stmt->execute()){
    echo 'success';
}
else{
    echo 'Error: '.$stmt->error;
}
?>