<?php
include 'connect.php';
session_start();

// Get Edit Account
if (isset($_GET['action']) && $_GET['action'] === 'edit-account') {
    $accountId = $_SESSION['userID'];
    $stmt = $conn->prepare("SELECT id, username, email, image FROM accounts WHERE id = ?");
    $stmt->bind_param("i", $accountId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $account = $result->fetch_assoc();
        $account['image'] = !empty($account['image']) ?
            'data:image/jpeg;base64,' . base64_encode($account['image']) :
            'assets/default-user.png';
        $account_details = [
            'id' => $account['id'],
            'username' => $account['username'],
            'email' => $account['email'],
            'image' => $account['image']
        ];

        echo json_encode($account_details);
    } else {
        echo json_encode(null);
    }
    $stmt->close();
    $conn->close();
}


// Update Account
if (isset($_POST['action']) && $_POST['action'] === 'update-account') {
    $accountId = $_SESSION['userID'];
    $username = $_POST['edit-username'];
    $email = $_POST['edit-email'];
    $password = $_POST['edit-password'];
    $croppedImage = $_POST['edit-account-cropped-image'];

    if (empty($username) || empty($email)) {
        echo "Username and working email are required.";
        exit;
    }

    // Convert base64 to binary if image is present
    if (!empty($croppedImage) && preg_match('/^data:image\/(\w+);base64,/', $croppedImage)) {
        $croppedImage = substr($croppedImage, strpos($croppedImage, ',') + 1);
        $croppedImage = base64_decode($croppedImage);
    } else {
        $croppedImage = null;
    }

    $fields = "username = ?, email = ?";
    $types = "ss";
    $params = [$username, $email];

    if (!empty($password)) {
        $fields .= ", password = ?";
        $types .= "s";
        $params[] = password_hash($password, PASSWORD_BCRYPT);
    }

    if ($croppedImage) {
        $fields .= ", image = ?";
        $types .= "b";
        $params[] = $croppedImage;
    }

    $fields .= " WHERE id = ?";
    $types .= "i";
    $params[] = $accountId;

    $sql = "UPDATE accounts SET $fields";
    $stmt = $conn->prepare($sql);

    // Prepare bind_param arguments
    $bind_names[] = $types;
    foreach ($params as $i => $param) {
        $bind_names[] = &$params[$i];
    }
    call_user_func_array([$stmt, 'bind_param'], $bind_names);

    // If image is present, send long data
    if ($croppedImage) {
        $imgIndex = array_search($croppedImage, $params);
        $stmt->send_long_data($imgIndex, $croppedImage);
    }

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        
        // Fetch the updated image from the database
        $stmt2 = $conn->prepare("SELECT image FROM accounts WHERE id = ?");
        $stmt2->bind_param("i", $accountId);
        $stmt2->execute();
        $stmt2->bind_result($img);
        $stmt2->fetch();
        $_SESSION['user_image'] = $img;
        $stmt2->close();
        echo "Updated account";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}