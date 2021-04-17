<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false))
{
    header('Location: login.php');
    exit();
}
echo "Logged in as ".$_SESSION['ulogin']."<br><br>";
echo "Hi ".$_SESSION['realname'].$_SESSION['realsurname']."<br>";
echo "Your account's balance is".$_SESSION['ubank']."<br>";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="styles/loginStyle.css">
</head>
<body>
    <form class="container" action="logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>
</body>
</html>