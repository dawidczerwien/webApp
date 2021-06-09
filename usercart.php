<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false)) {
    header('Location: login.php');
    exit();
}

require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_SESSION['mess'])){
        echo $_SESSION['mess'];
        unset($_SESSION['mess']);
    }
    $stmt = $conn->prepare('SELECT * FROM cart WHERE userid = ?');
    $stmt->execute(array($_SESSION['id']));
    if($stmt->rowCount() > 0) {
        echo "Your cart items: <br><br>"
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "ID:".$row['prodid']."<br>";
        }
    }
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
