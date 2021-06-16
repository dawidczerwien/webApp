<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false)) {
    $_SESSION['err'] = "You have to log in first!";
    header('Location: login.php');
    exit();
}

function addProduct($conn, $UID, $PID) {
    $stmt = $conn->prepare("INSERT INTO cart (`userid`, `prodid`) VALUES (?, ?)");
    $stmt->execute(array($UID, $PID));
    return '<span style="color:green">Product added to Your cart!</span>';
}


require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['PID'])){
        $_SESSION['mess'] = addProduct($conn, $_SESSION['id'], $_POST['PID']);
        unset($_POST['PID']);
        header('Location: usercart.php');
    }
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
