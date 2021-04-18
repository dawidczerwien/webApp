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
    $stmt = $conn->prepare('SELECT * FROM users WHERE uname = ?');
    $stmt->execute(array($_POST['inlogin']));
    $outcome = $stmt->fetch();
    if($stmt->rowCount() > 0)
    {
        $stmt = $conn->prepare('SELECT upass FROM users WHERE uname = ?');
        $stmt->execute(array($_POST['inlogin']));
        $hass = $stmt->fetch();
        $_SESSION['info'] = $hass;

        
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

