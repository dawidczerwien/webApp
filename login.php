<?php
session_start();
//if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true))
//{
//    header('Location: login.php');
//    exit();
//}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="styles/loginStyle.css">
</head>
<body>
<?php
$sql = "SELECT * from users";
require_once "connection.php";
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
if(isset($_SESSION['err']))
echo $_SESSION['err'];

}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>




  <form class="container" action="session.php" method="POST">
  <h2>Sign in</h2>
  <input type="text" name="inlogin" placeholder="Enter Username">
  <input type="password" name="inpass" placeholder="Enter Password">
  <button type="submit">Login</button>
  <a href="register.php">Don't have account Yet <p>Sign up</p></a>
</form>



</body>
</html>
