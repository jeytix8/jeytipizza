<?php
include 'connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM accounts";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows){
    $row = $result->fetch_assoc();

    if($row['username'] == $username && $row['password'] == $password){
        header('Location: ../main.html');
    }
    else{
        header('Location: ../#login');
    }
}
?>