<?php
session_start();
if((!isset($_POST['inlogin'])) || (!isset($_POST['inpass'])))
{
    header('Location: login.php');
    exit();
}
require_once "connection.php";
try
{
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully<br>";
    $stmt = $conn->prepare('SELECT * FROM users WHERE uname = ? and upass = ?');
    $stmt->execute(array($_POST['inlogin'], $_POST['inpass']));
    $outcome = $stmt->fetch();
    if($stmt->rowCount() > 0)
    {
        $_SESSION['loggedin'] = true;
        $_SESSION['id'] = $outcome['id'];
        $_SESSION['ubank'] = $outcome['ubank'];
        $_SESSION['realname'] = $outcome['realname'];
        $_SESSION['realsurname'] = $outcome['realsurname'];
        
        print "Witaj {$_SESSION['realname']} {$_SESSION['realsurname']}!<br><br>";
        print "Masz na koncie <b>{$_SESSION['ubank']}</b>";

    }
if(isset($_SESSION['err']))
echo $_SESSION['err'];

}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>

