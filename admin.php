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

    echo "<h1>ALL USER DATA</h1>";
    $stmt = $conn->prepare('SELECT * FROM users ORDER BY id DESC');
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['id']."     ";
            echo $row['uname']."     ";
            echo $row['upass']."     ";
            echo $row['ubank']."     ";
            echo $row['realname']."     ";
            echo $row['realsurname']."     ";
            echo $row['uemail']."     ";
            echo "<br><br>";
        }
    }
    echo "<h1>ALL PRODUCTS DATA</h1>";
    $stmt = $conn->prepare('SELECT * FROM prod ORDER BY put_date DESC');
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['id']."     ";
            echo $row['price']."     ";
            echo $row['name']."     ";
            echo $row['description']."     ";
            echo $row['user_id']."     ";
            echo $row['amount']."     ";
            echo $row['put_date']."     ";
            echo "<br><br>";
        }
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>