<?php
// Session start karein, jisse hum login status ko track kar payenge
session_start();

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
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];
    
    // SQL query likhein
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Password verify karein
        if (password_verify($input_password, $row['password'])) {
            // Login successful
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_type'] = $row['user_type'];

            // Ab user ko Dashboard.html par bhej dein
            header("Location: Dashboard.html");
            exit();
        } else {
            // Galat password
            echo "Invalid password. <a href='index.html'>Try again</a>";
        }
    } else {
        // User mila hi nahi
        echo "No user found with that username. <a href='index.html'>Try again</a>";
    }
}

$conn->close();
?>