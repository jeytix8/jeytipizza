<?php
include 'connect.php';
session_start();

// Create Product
if (
    isset($_POST['action']) && $_POST['action'] === 'create' &&
    isset($_POST['add-product-name']) &&
    isset($_POST['add-product-description']) &&
    isset($_POST['add-product-price']) &&
    isset($_POST['add-cropped-image'])
) {
    $name = trim($_POST['add-product-name']);
    $description = trim($_POST['add-product-description']);
    $price = trim($_POST['add-product-price']);
    $croppedImage = $_POST['add-cropped-image'];

    if (empty($name) || empty($description) || empty($price)) {
        echo "All fields are required.";
        exit;
    }

    if (empty($croppedImage)) {
        echo "Image is required.";
        exit;
    }
    // Convert base64 to binary
    if (preg_match('/^data:image\/(\w+);base64,/', $croppedImage, $type)) {
        $croppedImage = substr($croppedImage, strpos($croppedImage, ',') + 1);
        $croppedImage = base64_decode($croppedImage);
    } else {
        $croppedImage = null;
    }

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $description, $price, $croppedImage);

    if ($stmt->execute()) {
        echo "Add";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Read Product
if (isset($_GET['action']) && $_GET['action'] === 'read') {
    $result = $conn->query("SELECT id, name, description, price, status, image FROM products");

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // If image exists use it, else placeholder
            if (!empty($row['image'])) {
                $imageSrc = 'data:image/jpeg;base64,' . base64_encode($row['image']);
            } else {
                $imageSrc = 'assets/pizza.png';
            }

            echo '
                <tr>
                    <th scope="row">' . $row['id'] . '</th>
                    <td><img src="' . $imageSrc . '" alt="' . htmlspecialchars($row['name']) . '" width="32"></td>
                    <td>' . htmlspecialchars($row['name']) . '</td>
                    <td>' . htmlspecialchars($row['description']) . '</td>
                    <td>&#8369 ' . number_format($row['price']) . '</td>
                    <td>
                        <select class="form-select form-select-sm">
                            <option value="product-avail" ' . ($row['status'] === 'Available' ? 'selected' : '') . '>Available</option>
                            <option value="product-sold" ' . ($row['status'] === 'Sold Out' ? 'selected' : '') . '>Sold Out</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary edit-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#edit-modal" 
                                data-id="' . $row['id'] . '">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" 
                                data-id="' . $row['id'] . '">Delete</button>
                    </td>
                </tr>
            ';
        }
    } else {
        echo '<tr><td colspan="7" class="text-center">No products found.</td></tr>';
    }

    $conn->close();
}

// Get Edit Product
if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    $productId = $_GET['id'];
    $stmt = $conn->prepare("SELECT id, name, description, price, image FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $product['image'] = 'data:image/jpeg;base64,' . base64_encode($product['image']);
        $product_details = [
            'id' => $product['id'],
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $product['price'],
            'image' => $product['image']
        ];

        echo json_encode($product_details);
    } else {
        echo json_encode(null);
    }
    $stmt->close();
    $conn->close();
}

// Update Product
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $productId = $_POST['id'];
    $name = $_POST['edit-product-name'];
    $description = $_POST['edit-product-description'];
    $price = $_POST['edit-product-price'];
    $croppedImage = $_POST['edit-cropped-image'];

    if (empty($name) || empty($description) || empty($price) || empty($croppedImage)) {
        echo "All fields are required.";
        exit;
    }

    // Convert base64 to binary
    if (preg_match('/^data:image\/(\w+);base64,/', $croppedImage, $type)) {
        $croppedImage = substr($croppedImage, strpos($croppedImage, ',') + 1);
        $croppedImage = base64_decode($croppedImage);
    } else {
        $croppedImage = null;
    }

    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssdsi", $name, $description, $price, $croppedImage, $productId);

    if ($stmt->execute()) {
        echo "Update";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

if (isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $productId = $_POST['id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE products SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $productId);
    if ($stmt->execute()) {
        echo "Status updated!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}

// Delete Product
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $productId = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    if ($stmt->execute()) {
        echo "Delete";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}