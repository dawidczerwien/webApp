<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false) && ($_SESSION['role'] != "Admin") ) {
    header('Location: login.php');
    exit();
}

require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('UPDATE users SET isbanned = 1 WHERE id = ?');
    $stmt->execute(array($_POST['id']));
    $_SESSION['mess'] = "User account of ID: ".$_POST['id']." was deactivated";
    header('Location: usermod.php');
    exit();
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>