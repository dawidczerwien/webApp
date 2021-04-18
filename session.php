<?php
session_start();
if((!isset($_POST['inlogin'])) || (!isset($_POST['inpass'])))  //If user is not logged in send him back to login.php
{
    header('Location: login.php');
    exit();
}
require_once "connection.php";
try
{
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $passhash = password_hash($_POST['inpass'], PASSWORD_BCRYPT);
    $stmt = $conn->prepare('SELECT * FROM users WHERE uname = ? and upass = ?');
    $stmt->execute(array($_POST['inlogin'], $passhash));
    $outcome = $stmt->fetch();
    if($stmt->rowCount() > 0)
    {
        $_SESSION['loggedin'] = true;
        $_SESSION['id'] = $outcome['id'];
		$_SESSION['ulogin'] = $outcome['ulogin'];
        $_SESSION['ubank'] = $outcome['ubank'];
        $_SESSION['realname'] = $outcome['realname'];
        $_SESSION['realsurname'] = $outcome['realsurname'];
        unset($_SESSION['err']);
		header('Location: userpage.php');
		exit();
    }
	else 
	{
		$_SESSION['err'] = '<span style="color:red">Incorrect login and/or password!</span>';
		header('Location: login.php');
		exit();
	}
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>

