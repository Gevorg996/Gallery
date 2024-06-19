<?php
session_start();
require 'database-connection.php';

function loginUser($email, $password) {
    $conn = connectDB();
    
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    $query = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $stmt->close();
            $conn->close();

            $_SESSION['user_id'] = $id;
            return "success";
        } else {
            $stmt->close();
            $conn->close();
            return "Invalid email or password";
        }
    } else {
        $stmt->close();
        $conn->close();
        return "Invalid email or password";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = loginUser($email, $password);
    if ($result === "success") {
        header("Location: index.php");
        exit();
    } else {
        echo $result;
    }
}
?>
