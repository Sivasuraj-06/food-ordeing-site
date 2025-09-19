<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.location.href='register.html';</script>";
        exit();
    }

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful. You can now log in.'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='register.html';</script>";
    }

    $stmt->close();
}
?>
