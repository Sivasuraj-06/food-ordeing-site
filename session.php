<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html"); 
    exit();
}
if (isset($_SESSION['loggedin_time']) && (time() - $_SESSION['loggedin_time'] > 600)) {
    session_unset(); 
    session_destroy(); 
    header("Location: index.html"); 
    exit();
}
?>
