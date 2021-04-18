<?php
session_start();
if((!isset($_POST['inlogin'])) || (!isset($_POST['inpass']))) {  //If user is not logged in send him back to login.php
    header('Location: login.php');
    exit();
}
require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('SELECT * FROM users WHERE uname = ?');
    $stmt->execute(array($_POST['inlogin']));
    $outcome = $stmt->fetch();
    if($stmt->rowCount() > 0) {
        $stmt2 = $conn->prepare('SELECT upass FROM users WHERE uname = ?');
        $stmt2->execute(array($_POST['inlogin']));
        $hashpass = $stmt2->fetch();
        if(password_verify($_POST['inpass'], $hashpass['upass'])){
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $outcome['id'];
            $_SESSION['uname'] = $outcome['uname'];
            $_SESSION['ubank'] = $outcome['ubank'];
            $_SESSION['realname'] = $outcome['realname'];
            $_SESSION['realsurname'] = $outcome['realsurname'];
            unset($_SESSION['err']);
            header('Location: userpage.php');
            exit();
        } else {
            $_SESSION['err'] = '<span style="color:red">Incorrect password!</span>';
            header('Location: login.php');
            exit();
        }
    }
	else {
		$_SESSION['err'] = '<span style="color:red">Incorrect login!</span>';
		header('Location: login.php');
		exit();
	}
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

