<?php
function dbCreateProduct($conn, $price, $name, $desc, $uid, $number) {
    $stmt = $conn->prepare("INSERT INTO prod (`price`, `name`, `description`, `user_id`, `amount`) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(array($price, $name, $desc, $uid, $number));
}
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false)) {
    $_SESSION['err'] = "You have to log in first!";
    header('Location: login.php');
    exit();
}
require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (!isset($_POST['inname']) || $_POST['inname'] == '') {
        $_SESSION['err'] = '<span style="color:red">You have to specify product\'s name!</span>';
        header('Location: addproduct.php');
        exit();
    }
    if (!isset($_POST['indesc']) || $_POST['indesc'] == '') {
        $_SESSION['err'] = '<span style="color:red">You have to specify product\'s description!</span>';
        header('Location: addproduct.php');
        exit();
    }
    if (!isset($_POST['inprice']) || $_POST['inprice'] == '') {
        $_SESSION['err'] = '<span style="color:red">You have to specify product\'s price!</span>';
        header('Location: addproduct.php');
        exit();
    }
    if (!isset($_POST['innumber']) || $_POST['innumber'] == '') {
        $_SESSION['err'] = '<span style="color:red">You have to specify product\'s quantity!</span>';
        header('Location: addproduct.php');
        exit();
    }

    dbCreateProduct($conn, $_POST['inprice'], $_POST['inname'], $_POST['indesc'], $_SESSION['id'], $_POST['innumber']);
    unset($_SESSION['err']);
    $_SESSION['mess'] = '<span style="color:green">New product added successfully!</span>';
    header('Location: index.php');
    exit();

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>