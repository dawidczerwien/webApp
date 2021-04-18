<?php
function emailFormatCheck($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) return true;
    return false;
}

function passwordsAreTheSameCheck($pass1, $pass2) {
    if ($pass1 == $pass2) return true;
    return false;
}

function passwordStrenghtCheck($password) {
    $hasUppercase = preg_match('@[A-Z]@', $password);
    $hasLowercase = preg_match('@[a-z]@', $password);
    $hasNumber    = preg_match('@[0-9]@', $password);
    $hasSpecialChars = preg_match('@[^\w]@', $password);
    if (!$hasUppercase || !$hasLowercase || !$hasNumber || !$hasSpecialChars || strlen($password) < 8) return false;
    return true;
}

function dbEmailExistsCheck($conn, $email) {
    $stmt = $conn->prepare('SELECT * FROM users WHERE uemail = ?');
    $stmt->execute(array($email));
    if($stmt->rowCount() == 0) return true;
    return false;
}

function dbLoginExistsCheck($conn, $login) {
    $stmt = $conn->prepare('SELECT * FROM users WHERE uname = ?');
    $stmt->execute(array($login));
    if($stmt->rowCount() == 0) return true;
    return false;
}

function dbCreateUser($conn, $login, $pass, $email) {
    $passhash = password_hash($pass, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (`uname`, `upass`, `uemail`) VALUES (?, ?, ?)");
    $stmt->execute(array($login, $passhash, $email));
}

session_start();
require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!passwordsAreTheSameCheck($_POST['inpass'], $_POST['inConfirmPass'])) {
        $_SESSION['err'] = '<span style="color:red">Passwords are not the same!</span>';
        header('Location: register.php');
        exit();
    }
    if (!emailFormatCheck($_POST['inEmail'])) {
        $_SESSION['err'] = '<span style="color:red">Invalid email format!</span>';
        header('Location: register.php');
        exit();
    }
    if (!passwordStrenghtCheck($_POST['inpass'])) {
        $_SESSION['err'] = '<span style="color:red">Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character!</span>';
        header('Location: register.php');
        exit();
    }
    if (!dbLoginExistsCheck($conn, $_POST['inlogin'])) {
        $_SESSION['err'] = '<span style="color:red">User with such login already exists!</span>';
		header('Location: register.php');
		exit();
    }
    if (!dbEmailExistsCheck($conn, $_POST['inEmail'])) {
        $_SESSION['err'] = '<span style="color:red">User with such email address already exists!</span>';
		header('Location: register.php');
		exit();
    }
    
    dbCreateUser($conn, $_POST['inlogin'], $_POST['inpass'], $_POST['inEmail']);
    unset($_SESSION['err']);
    $_SESSION['mess'] = '<span style="color:green">New user created successfully!</span>';
    header('Location: login.php');
    exit();

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

