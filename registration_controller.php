<?php
require 'database-connection.php';

function registerUser($name, $email, $password) {
    $conn = connectDB();
    
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    $emailCheckQuery = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->close();
        $conn->close();
        return "Email already exists";
    }
    
    $stmt->close();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertQuery = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sss", $name, $email, $hashedPassword);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return "success";
    } else {
        $stmt->close();
        $conn->close();
        return "Registration failed";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match";
    } else {
        $result = registerUser($name, $email, $password);
        if ($result === "success") {
            header("Location: login.php");
            exit();
        } else {
            echo $result;
        }
    }
}
?>
