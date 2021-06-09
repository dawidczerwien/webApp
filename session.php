<?php
function dbLoginExistsCheck($conn, $login) { //Nie istnieje=true, instnieje=false
    $stmt = $conn->prepare('SELECT id FROM users WHERE uname = ?');
    $stmt->execute(array($login));
    if($stmt->rowCount() == 0) return true;
    return false;
}

function dbPasswordCheck($conn, $login, $pass) {
    $stmt = $conn->prepare('SELECT upass FROM users WHERE uname = ?');
    $stmt->execute(array($login));
    $hashpass = $stmt->fetch();
    if(password_verify($pass, $hashpass['upass'])) return true;
    return false;
}

function userBanned($conn, $uname) {
    $stmt = $conn->prepare('SELECT isbanned FROM users WHERE uname = ?');
    $stmt->execute(array($uname));
    $isbanned = $stmt->fetch();
    $_SESSION['mess'] = $isbanned['isbanned']."  ".gettype($isbanned['isbanned']);
    if($isbanned == 1) return true;
    return false;
}

session_start();
if((!isset($_POST['inlogin'])) || (!isset($_POST['inpass']))) {  //If user is not logged in send him back to login.php
    header('Location: login.php');
    exit();
}
require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(userBanned($conn, $_POST['inlogin'])) {
        $_SESSION['err'] = '<span style="color:red">User\'s account is banned!</span>';
        header('Location: login.php');
        exit();
    }
    
    if(dbLoginExistsCheck($conn, $_POST['inlogin'])) {
        $_SESSION['err'] = '<span style="color:red">User doesn\'t exist!</span>';
        header('Location: login.php');
        exit();
    }
    if(!dbPasswordCheck($conn, $_POST['inlogin'], $_POST['inpass'])) {
        $_SESSION['err'] = '<span style="color:red">Incorrect password!</span>';
        header('Location: login.php');
        exit();
    }
    
    $stmt = $conn->prepare('SELECT * FROM users WHERE uname = ?');
    $stmt->execute(array($_POST['inlogin']));
    $outcome = $stmt->fetch();
    $_SESSION['loggedin'] = true;
    $_SESSION['id'] = $outcome['id'];
    $_SESSION['uname'] = $outcome['uname'];
    $_SESSION['ubank'] = $outcome['ubank'];
    $_SESSION['realname'] = $outcome['realname'];
    $_SESSION['realsurname'] = $outcome['realsurname'];
    $_SESSION['role'] = $outcome['role'];
    unset($_SESSION['err']);
    header('Location: userpage.php');
    exit();
} 
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>