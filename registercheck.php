<?php
session_start();
require_once "connection.php";
try
{
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('SELECT * FROM users WHERE uname = ? OR uemail = ?');
    $stmt->execute(array($_POST['inlogin'], $_POST['inEmail']));
    $outcome = $stmt->fetch();
    if($stmt->rowCount() == 0)
    {
        $stmt = $conn->prepare("INSERT INTO users ('uname', 'upass', 'ubank', 'uemail') VALUES (?, ?, ?, ?)");
        $stmt->execute(array($_POST['inlogin'], $_POST['inpass'], 0, $_POST['inEmail']));
        unset($_SESSION['err']);
		header('Location: userpage.php');
		exit();
    }
	else 
	{
		$_SESSION['err'] = '<span style="color:red">User with such login or email already exists!</span>';
		header('Location: register.php');
		exit();
	}
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>

