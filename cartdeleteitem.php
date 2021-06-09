<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false)) {
    header('Location: login.php');
    exit();
}

require_once "connection.php";
try {
    if(!isset($_POST['PID'])){
        header('Location: login.php');
        exit();
    }
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('DELETE FROM cart WHERE prodid = ? AND userid = ?');
    $stmt->execute(array($_POST['PID'], $_SESSION['id']));
    $_SESSION['mess'] = "Product of id: ".$_POST['id']." was deleted from cart";
    header('Location: usercart.php');
    exit();
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>