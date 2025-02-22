<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = $conn->query("SELECT * FROM products WHERE id = $id");
    $product = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $price = $_POST["price"];
        $description = $_POST["description"];
        
        // Check if a new image is uploaded
        if (!empty($_FILES["image"]["name"])) {
            $targetDir = "uploads/";
            $imageName = basename($_FILES["image"]["name"]);
            $targetFile = $targetDir . $imageName;
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

            // Update with new image
            $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
            $stmt->bind_param("sdssi", $name, $price, $description, $imageName, $id);
        } else {
            // Update without changing image
            $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
            $stmt->bind_param("sdsi", $name, $price, $description, $id);
        }

        if ($stmt->execute()) {
            header("Location: index.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<form method="post" enctype="multipart/form-data" style="width: 50%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9; text-align: center;">
    <h2 style="margin-bottom: 15px;">Update Product</h2>

    <input type="text" name="name" value="<?php echo $product['name']; ?>" required 
        style="width: 90%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
    
    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required 
        style="width: 90%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

    <textarea name="description" 
        style="width: 90%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; height: 80px;"><?php echo $product['description']; ?></textarea>

    <input type="file" name="image" 
        style="margin-bottom: 15px;">
    
    <button type="submit" 
        style="width: 94%; padding: 10px; background: orange; color: white; border: none; border-radius: 5px; cursor: pointer;">
        Update Product
    </button>
</form>


