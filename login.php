<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="styles/loginStyle.css">
</head>
<body>

<?php
$host = "mysql-server";
$user = "root";
$pass = "secret1234";
$db = "webapp";
$sql = "SELECT * from users";
try
{
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully<br>";
    if (isset($_POST['inlogin']))
    {
        print "Wpisano login: " . $_POST['inlogin'];
        print "<br>";
    }
    else
    {
        print "Nie wpisano loginu<br>";
    }
    if (isset($_POST['inpass']))
    {
        print "Wpisano haslo: " . $_POST['inpass'];
        print "<br>";
    }
    else
    {
        print "Nie wpisano hasla<br>";
    }

}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>



<form class="container" action="login.php" method="POST">
  <h2>LOGOWANIE</h2>
  <input type="text" name="inlogin" placeholder="Enter Username">
  <input type="password" name="inpass" placeholder="Enter Password">
  <button type="submit">Login</button>
</form>



</body>
</html>
