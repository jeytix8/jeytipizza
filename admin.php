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
            <a class="navbar-brand d-flex align-items-center" href="">
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
                        <img class="rounded" src="
                            <?php
                                if (!empty($_SESSION['user_image'])) {
                                    echo 'data:image/jpeg;base64,' . base64_encode($_SESSION['user_image']);
                                } else {
                                    echo 'assets/default-user.png';
                                }
                            ?>
                        " alt="profile" width="30">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end bg-text-light" id="dropdown-profile">
                        <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#account-modal"
                                id="account-btn">Account</button></li>
                        <li><a class="dropdown-item" href="controller/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div id="content">
    </div>

    <!--Account Modal -->
    <div class="modal fade" id="account-modal" tabindex="-1" aria-labelledby="account-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="account-modalLabel">Account Settings</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Information -->
                <form id="edit-account-form" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit-account-id">

                    <div class="modal-body">
                        <!-- Image Preview -->
                        <div class="mb-2 text-center">
                            <img id="edit-account-image-preview" src="" alt="Preview"
                                style="max-width:100px; display:none;">
                        </div>

                        <!-- Image Upload Box -->
                        <div class="input-group mb-2">
                            <label for="edit-account-image" class="form-control text-center" style="cursor:pointer;">
                                <span id="edit-account-upload-label">Upload</span>
                                <input type="file" id="edit-account-image" name="edit-account-image" accept="image/*"
                                    style="display:none;">
                            </label>
                        </div>

                        <!-- Username -->
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" class="form-control" placeholder="Username" name="edit-username"
                                required>
                        </div>

                        <!-- Email -->
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" class="form-control" placeholder="Email" name="edit-email" required>
                        </div>

                        <!--Change Password -->
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" placeholder="New Password (optional)"
                                name="edit-password">
                        </div>
                        <input type="hidden" name="edit-account-cropped-image" id="edit-account-cropped-image">
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-danger" id="update-account-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
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