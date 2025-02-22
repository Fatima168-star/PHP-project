<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];

    // Image Upload
    $targetDir = "uploads/";
    $imageName = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $imageName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

    $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $description, $imageName);

    if ($stmt->execute()) {
        echo "Product added successfully!";
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<form method="post" enctype="multipart/form-data" style="width: 50%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9; text-align: center;">
    <h2 style="margin-bottom: 15px;">Add New Product</h2>

    <input type="text" name="name" placeholder="Product Name" required 
        style="width: 90%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
    
    <input type="number" step="0.01" name="price" placeholder="Price" required 
        style="width: 90%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

    <textarea name="description" placeholder="Product Description" 
        style="width: 90%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; height: 80px;"></textarea>

    <input type="file" name="image" required 
        style="margin-bottom: 15px;">

    <button type="submit" 
        style="width: 94%; padding: 10px; background: green; color: white; border: none; border-radius: 5px; cursor: pointer;">
        Add Product
    </button>
</form>

