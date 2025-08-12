<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['type'] == 'customer') {
    header("Location: main.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>
</head>
<body>
    Hi, Administrator!

    <a class="dropdown-item" href="controller/logout.php">Logout</a>
    
    <script src="script/cache-resetter.js"></script>
</body>
</html>
