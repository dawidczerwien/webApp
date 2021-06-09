<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false)) {
    header('Location: login.php');
    exit();
}

function addProduct($conn, $UID, $PID) {
    $stmt = $conn->prepare("INSERT INTO cart (`userid`, `prodid`) VALUES (?, ?)");
    $stmt->execute(array($UID, $PID));
    return "Product added to Your cart!";
}


require_once "connection.php";
echo "Products PID:".$_POST['PID']."<br><br>";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['PID'])){
        $resp = addProduct($conn, $_SESSION['id'], $_POST['PID']);
        echo $resp;
        unset($_POST['PID']);
    }
    $stmt = $conn->prepare('SELECT * FROM cart WHERE userid = ?');
    $stmt->execute(array($_SESSION['id']));
    if($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Product id:".$row['prodid']."<br>";
        }
    }
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
