<?php
function dbCreateProduct($conn, $price, $name, $desc, $uid, $number) {
    $stmt = $conn->prepare("INSERT INTO prod (`price`, `name`, `description`, `user_id`, `amount`) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(array($price, $name, $desc, $uid, $number));
}
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false)) {
    header('Location: login.php');
    exit();
}
require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    dbCreateProduct($conn, $_POST['inprice'], $_POST['inname'], $_POST['indesc'], $_SESSION['id'], $_POST['innumber']);
    unset($_SESSION['err']);
    $_SESSION['mess'] = '<span style="color:green">New user created successfully!</span>';
    ob_flush();
    header('Location: index.php');
    exit();

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

