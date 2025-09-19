<?php
session_start();
include 'database.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['loggedin_time'] = time(); 
            header("Location: order.php");
            exit();
        } else {
            echo "<script>alert('Invalid credentials. Please try again.'); window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('User not found. Please register.'); window.location.href='register.html';</script>";
    }

    $stmt->close();
}
?>
