<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST["FullName"];
    $email = $_POST["Email"];
    $password = $_POST["Password"];
    $dob = $_POST["DOB"];
    $gender = $_POST["Gender"];
    $sql = "INSERT INTO registration (FullName, Email, Password, DOB, Gender) 
    VALUES ('$fullName', '$email', '$password', '$dob', '$gender')";

    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green; font-weight: bold;'>Registration Successful!</p>";
        header("Location: login.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh;">

<div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); width: 300px;">
    <h2 style="text-align: center;">Register</h2>
    <form method="post">
        
        <div style="margin-bottom: 15px;">
            <label for="FullName" style="font-weight: bold; display: block;">Full Name:</label>
            <input type="text" id="FullName" name="FullName" placeholder="Enter your full name" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="Email" style="font-weight: bold; display: block;">Email:</label>
            <input type="email" id="Email" name="Email" placeholder="Enter your email" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="Password" style="font-weight: bold; display: block;">Password:</label>
            <input type="password" id="Password" name="Password" placeholder="Enter your password" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="DOB" style="font-weight: bold; display: block;">Date of Birth:</label>
            <input type="date" id="DOB" name="DOB" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block;">Gender:</label>
            <div style="display: flex; justify-content: space-between;">
                <label><input type="radio" name="Gender" value="Male" required> Male</label>
                <label><input type="radio" name="Gender" value="Female" required> Female</label>
            </div>
        </div>
        
        <button type="submit" style="width: 100%; padding: 10px; background: #28a745; color: white; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">Register</button>
        
    </form>
</div>

</body>
</html>