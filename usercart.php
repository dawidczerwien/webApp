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
        echo $_SESSION['mess']."<br><br>";
        unset($_SESSION['mess']);
    }
    $stmt = $conn->prepare('SELECT * FROM cart WHERE userid = ?');
    $stmt->execute(array($_SESSION['id']));
    if($stmt->rowCount() > 0) {
        echo "Your cart items: <br><br>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "prodID:".$row['prodid']."<br>";
            $stmt2 = $conn->prepare('SELECT * FROM prod WHERE id = ?');
            $stmt2->execute(array($row['prodid']));
            if($stmt2->rowCount() > 0) {
                while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    echo "id:".$row2['id']."<br>";
                    echo "price per item:".$row2['price']."<br>";
                    echo "name:".$row2['name']."<br>";
                    echo "<hr>";
                }
            }
        }
    }
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
