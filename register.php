<?php
// Database se connect karein
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hostel_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Connection check karein
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check karein ki form submit hua hai ya nahi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['signup-id'];
    $new_password = $_POST['signup-password'];
    $user_type = $_POST['user_type'];
    
    // Password ko surakshit (secure) banayein
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // SQL query likhein
    $sql = "INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $new_username, $hashed_password, $user_type);

    if ($stmt->execute()) {
        echo "Registration successful! <a href='index.html'>Login now</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>