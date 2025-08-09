<?php
session_start();

// Get the actual request URI (path after your domain)
$request_uri = $_SERVER['REQUEST_URI'];

// Check: if URI is just "/" or "/jeytipizza" (adjust if your folder name changes)
if (
    isset($_SESSION['userID']) &&
    ($request_uri === '/' || $request_uri === '/jeytipizza/' || $request_uri === '/jeytipizza')
) {
    header("Location: main.php");
    exit;
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
            padding: 130px 0;
        }
    </style>
</head>

<body>

    <nav class="navbar sticky-top navbar-expand-md bg-body-tertiary">
        <div class="container-md">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand d-md-none" href="#home"><img src="assets/pizza.png" alt="Jeytipizza" width="30"></a>
            <a class="navbar-brand d-none d-md-block" href="#home"><img src="assets/jeytipizza_text.png"
                    alt="Jeytipizza" width="100"></a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about" aria-disabled="true">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php" aria-disabled="true">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="content">
        <!-- Sections -->
    </div>

    <!-- Bootstrap -->
    <?php include 'includes/bootstrap.php'; ?>

    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <script src="script/bootstrap-function.js"></script>
    <script src="script/content-loader.js"></script>
    <script>
        // Function parameters sent to content-loader.js
        setContent({
            home: "landing/home.php",
            about: "landing/about.php"
        }, 'home');
    </script>
</body>

</html>