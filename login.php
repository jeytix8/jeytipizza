<?php
session_start();

if (isset($_SESSION['userID'])) {
    header('Location: main.php');
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
    <title>Login</title>
    <style>
        section {
            padding: 120px 0;
        }
    </style>
</head>

<body>
    <section class="" id="login">
        <div class="container-lg py-md-5 my-md-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-5 col-9 mb-5 text-md-start text-center text-decoration-none">
                    <a href="index.php"><img class="img-fluid" src="assets/jeytipizza_text.png" alt="Jeytipizza" width="300"></a><br>
                    <span class="fst-italic fs-5 fw-semibold text-muted">One Bite Starts It All.</span>
                    <img class="img-fluid" src="assets/pizza.png" alt="Jeytipizza" width="25">
                </div>
                <div class="col-md-5 col-9 p-2 text-center">
                    <!--Login Form -->
                    <form class="p-2" id="login_form">
                        <div class="input-group input-group-lg mb-3">
                            <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                            <input type="text" class="form-control" name="username" placeholder="Username or Email"
                                required autocomplete="off">
                        </div>

                        <div class="input-group input-group-lg mb-3">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-danger btn-lg" id="login-btn">Login</button>
                    </form>

                    <!-- Forgot Password -->
                    <p class="mt-2 p-2"><a class="text-decoration-none" type="button" data-bs-toggle="modal"
                            data-bs-target="#forgotpw">Forgot password?</a>
                    </p>

                    <!-- Modal: forgot password -->
                    <div class="modal fade" id="forgotpw" tabindex="-1" aria-labelledby="forgotpwLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title fs-5" id="forgotpwLabel">Reset Password</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <!-- form: reset password -->
                                <form class="p-3" id="forgot_form">
                                    <div class="modal-body justify-content-center p-4">

                                        <div class="input-group mb-2">
                                            <span class="input-group-text">
                                                <i class="bi bi-envelope"></i></span>
                                            <input type="text" class="form-control"
                                                placeholder="Enter your email or username" id="forgot-user" required>
                                            <button type="button" class="btn btn-secondary"
                                                id="forgot-sendcode-btn">Send
                                                code</button>
                                        </div>
                                        <!-- input group code -->
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-shield-lock"></i></span>
                                            <input type="text" id="forgot-code" class="form-control"
                                                placeholder="Enter code" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" class="btn btn-danger"
                                            id="forgot-verify-btn">Verify</button>
                                    </div>
                                </form>

                                <!-- form: enter new password -->
                                <form class="p-3 d-none" id="newpass_form">
                                    <div class="modal-body justify-content-center p-4">
                                        <!-- input group code -->
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-key"></i></span>
                                            <input type="password" id="newpass" class="form-control"
                                                placeholder="Enter new password" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" class="btn btn-danger" id="newpass-btn">Continue</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <!-- Sign Up -->
                    <p class="mt-2 p-2"><button class="text-decoration-none btn btn-dark btn-lg" type="button"
                            data-bs-toggle="modal" data-bs-target="#registerModal">Create new account</button>
                    </p>

                    <!-- Modal: Sign Up -->
                    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title fs-5" id="registerModalLabel">Sign Up</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <!--Register form -->
                                <form class="p-1" id="register_form">
                                    <div class="modal-body justify-content-center p-4">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">
                                                <i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" name="username"
                                                placeholder="Enter a username" required>
                                        </div>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">
                                                <i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Enter your email" required>
                                        </div>
                                        <!-- input group code -->
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-key"></i></span>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Enter a password" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <input type="hidden" name="register">
                                        <button type="submit" class="btn btn-danger" id="register-btn">Register</button>
                                    </div>
                                </form>

                                <!--Verify Code form -->
                                <form class="p-1 d-none" id="registerverify_form">
                                    <div class="modal-body justify-content-center p-4">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">
                                                <i class="bi bi-shield-lock"></i></span>
                                            <input type="text" class="form-control" name="register-verify-number"
                                                id="register-number" placeholder="Enter verification code" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" class="btn btn-danger">Continue</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap -->
    <?php include 'includes/bootstrap.php';?>

    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <script src="script/bootstrap-function.js"></script>
    <script src="script/login.js"></script>
    <script src="script/cache-resetter.js"></script>
</body>
</html>