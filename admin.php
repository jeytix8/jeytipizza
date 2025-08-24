<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['type'] == 'customer') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/pizza.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.css" />

    <title>Administrator</title>
    <style>
        section {
            padding: 50px 0;
        }

        #dropdown-profile {
            min-width: auto;
            width: auto;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand bg-black">
        <div class="container-md">
            <!-- logo -->
            <a class="navbar-brand d-flex align-items-center" href="#menu">
                <img src="assets/pizza.png" alt="Jeytipizza" width="30">
                <img class="d-none d-md-inline-block ms-2" src="assets/jeytipizza_text.png" alt="Jeytipizza"
                    width="100">
            </a>
            <!-- Profile -->
            <ul class="navbar-nav d-flex align-items-center">
                <li class="text-white text-end me-2"><small><?php echo $_SESSION['username']; ?></small></li>
                <!-- Profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link p-0" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="rounded" src="assets/avatar.png" alt="profile" width="30">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end bg-text-light" id="dropdown-profile">
                        <li><a class="dropdown-item" href="#profile">Profile</a></li>
                        <li><a class="dropdown-item" href="#settings">Settings</a></li>
                        <li><a class="dropdown-item" href="controller/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div id="content">
    </div>

    <!-- Bootstrap -->
    <?php include 'includes/bootstrap.php'; ?>

    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script/bootstrap-function.js"></script>
    <script src="script/cache-resetter.js"></script>
    <script src="script/content-loader.js"></script>
    <script src="script/admin.js"></script>
    <script>
        // Function parameters sent to content-loader.js
        setContent({
            content: "admin/content.php"
        }, 'content');
    </script>
</body>

</html>