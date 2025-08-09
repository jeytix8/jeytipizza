<?php
session_start();

if (!isset($_SESSION['userID'])) {
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
    <title>Jeytipizza</title>
    <style>
        section {
            padding: 50px 0;
        }

        .logo-white {
            filter: brightness(0) invert(1);
        }

        #dropdown-profile {
            min-width: auto;
            width: auto;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand bg-danger">
        <div class="container-md">
            <!-- logo -->
            <a class="navbar-brand logo-white d-flex align-items-center" href="#menu">
                <img src="assets/pizza.png" alt="Jeytipizza" width="30">
                <img class="d-none d-md-inline-block ms-2" src="assets/jeytipizza_text.png" alt="Jeytipizza"
                    width="100">
            </a>
            <!-- search -->
            <form class="d-flex align-items-center flex-grow-1 mx-1 mx-md-5" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>

            <!-- Cart and Profile -->
            <ul class="navbar-nav d-flex align-items-center">
                <!-- Cart -->
                <li class="nav-item mx-1 px-1 fs-4">
                    <a class="nav-link py-0" href="#cart"><i class="bi bi-cart2 text-white"></i></a>
                </li>
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
    <script src="script/bootstrap-function.js"></script>
    <script src="script/cache-resetter.js"></script>
    <script src="script/content-loader.js"></script>
    <script>
        // Function parameters sent to content-loader.js
        setContent({
            menu: "main/menu.php",
            cart: "main/cart.php"
        }, 'menu');
    </script>
</body>

</html>