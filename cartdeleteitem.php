<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false)) {
    $_SESSION['err'] = "You have to log in first!";
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
    $_SESSION['mess'] ='<span style="color:green">Product of id: '.$_POST['id'].' was deleted from cart</span>';
    header('Location: usercart.php');
    exit();
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>