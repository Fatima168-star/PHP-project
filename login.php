<?php
session_start();
include 'db.php'; // Include database connection

// Ensure form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Email"]) && isset($_POST["Password"])) {
    $email = trim($_POST["Email"]); 
    $password = trim($_POST["Password"]);

    if (!empty($email) && !empty($password)) {
        // Use prepared statement for security
        $stmt = $conn->prepare("SELECT * FROM registration WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Compare password (no hashing in this case)
            if ($password === $user['Password']) { 
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['FullName'];

                // Redirect after successful login
                header("Location: index.php");
                exit();
            } else {
                echo "<p style='color: red; text-align: center;'>Invalid credentials!</p>";
            }
        } else {
            echo "<p style='color: red; text-align: center;'>User not found!</p>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<p style='color: red; text-align: center;'>Please fill in all fields!</p>";
    }
    
    // Close connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh;">

<div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); width: 300px;">
    <h2 style="text-align: center;">Login</h2>
    
    

    <form method="post">
        <div style="margin-bottom: 15px;">
            <label for="email" style="font-weight: bold; display: block;">Email:</label>
            <input type="email" id="Email" name="Email" placeholder="Enter your email" required 
                   style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="password" style="font-weight: bold; display: block;">Password:</label>
            <input type="password" id="Password" name="Password" placeholder="Enter your password" required 
                   style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        
        <button type="submit" style="width: 100%; padding: 10px; background: #007bff; color: white; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">
            Login
        </button>
    </form>
</div>

</body>
</html>
