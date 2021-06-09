<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false)) {
    header('Location: login.php');
    exit();
}

function addProduct($conn, $UID, $PID) {
    $stmt = $conn->prepare("INSERT INTO cart (`userid`, `prodid`) VALUES (?, ?)");
    $stmt->execute(array($UID, $PID));
}


require_once "connection.php";
echo $_POST['PID'];
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('SELECT * FROM cart WHERE userid = ?');
    $stmt->execute(array($_SESSION['id']));
    if($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['prodid'];
        }
    }
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
