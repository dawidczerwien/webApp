<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
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
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>



<form class="container" action="registercheck.php" method="POST">
  <h2>Sign up</h2>
  <input type="text" name="inlogin" placeholder="Enter Username">
  <input type="password" name="inpass" placeholder="Enter Password">
  <input type="password" name="inConfirmPass" placeholder="Confirm Passward">
  <input type="text" name="inEmail" placeholder="Enter Email">
  <?php
	if(isset($_SESSION['err']))	
		echo $_SESSION['err'];
  ?>
  <button type="submit">Register</button>
  <a href="login.php">Already have account <p>Sign in </p></a>
</form>



</body>
</html>
