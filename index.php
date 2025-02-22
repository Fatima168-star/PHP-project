<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            background-color: palegoldenrod;
        }
        .auth-buttons {
            margin-top: 50px;
        }
        .auth-buttons a {
            text-decoration: none;
            padding: 10px 20px;
            margin: 10px;
            display: inline-block;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
        }
        .auth-buttons a:hover {
            background-color: #0056b3;
        }
        .container {
            width: 60%;
            margin: auto;
        }
        .product {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .product img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            display: block;
            margin: 10px auto;
        }
        .add-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: green;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-button:hover {
            background: darkgreen;
        }
        .logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout:hover {
            background: darkred;
        }
    </style>
</head>
<body>

<?php
if (!isset($_SESSION['user_id'])) { 
    // If user is not logged in, show Register & Login buttons
    echo "<div class='auth-buttons'>
            <a href='register.php'>Register</a>
            <a href='login.php'>Login</a>
            <h1>Welcome To Our Website</h1>
            <p>Register yourself if you are new to our website</p><br/>
            <p>If you already Registered,then direct Login</p>
          </div>";
} else {
    // If user is logged in, show the product list and logout button
    echo "<h2>Welcome, " . $_SESSION['user_name'] . "!</h2>";
    echo "<a href='logout.php' class='logout'>Logout</a><br><br>";

    $result = $conn->query("SELECT * FROM products");

    echo "<h2>Products</h2>";
    echo "<a href='createProduct.php' class='add-button'>Add Product</a>";
    echo "<div class='container'>";

    if ($result->num_rows > 0) {
        while ($product = $result->fetch_assoc()) {
            echo "<div class='product' 
            style='border: 1px solid #ddd; padding: 15px; margin: 10px; border-radius: 8px; 
                   background: #f9f9f9; text-align: center; width: 250px; display: inline-block;'>

            <h3 style='margin-bottom: 10px; color: #333;'>{$product['name']}</h3>
            
            <img src='uploads/{$product['image']}' alt='{$product['name']}' 
                style='width: 150px; height: 150px; border-radius: 5px; margin-bottom: 10px;'>

            <p style='color: #666; font-size: 14px;'>{$product['description']}</p>
            <p style='color: green; font-weight: bold;'><strong>Price:</strong> {$product['price']}</p>

            <a href='updateProduct.php?id={$product['id']}' 
                style='display: inline-block; padding: 10px 15px; margin: 5px; text-decoration: none; 
                       background: orange; color: white; border-radius: 5px; font-weight: bold;'>
                Update
            </a>

            <a href='deleteProduct.php?id={$product['id']}' 
                style='display: inline-block; padding: 10px 15px; margin: 5px; text-decoration: none; 
                       background: red; color: white; border-radius: 5px; font-weight: bold;'>
                Delete
            </a>

          </div>";

        }
    } else {
        echo "<p>No products available.</p>";
        
    }

    echo "</div>";
}

$conn->close();
?>

</body>
</html>
