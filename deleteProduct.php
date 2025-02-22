<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch image name to delete it from folder
    $result = $conn->query("SELECT image FROM products WHERE id = $id");
    $product = $result->fetch_assoc();
    $imagePath = "uploads/" . $product['image'];

    if (file_exists($imagePath)) {
        unlink($imagePath); // Delete image from folder
    }

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
