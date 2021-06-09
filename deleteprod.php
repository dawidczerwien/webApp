<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false) && ($_SESSION['role'] != "Admin") ) {
    header('Location: login.php');
    exit();
}

require_once "connection.php";
if(!isset($_POST['id']){
    header('Location: login.php');
    exit();
})
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('DELETE FROM prod WHERE id = ?');
    $stmt->execute(array($_POST['id']));
    $_SESSION['mess'] = "Product of id: ".$_POST['id']." was deleted";
    header('Location: prodmod.php');
    exit();
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>