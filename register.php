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

<form class="container" action="registercheck.php" method="POST">
  <h2>Sign up</h2>
  <input type="text" name="inlogin" placeholder="Enter Username">
  <input type="password" name="inpass" placeholder="Enter Password">
  <input type="password" name="inConfirmPass" placeholder="Confirm Passward">
  <input type="text" name="inEmail" placeholder="Enter Email">
  <?php
	if(isset($_SESSION['err']))	{
		echo $_SESSION['err']."<br>";
    unset( $_SESSION['err']);
  }
  ?>
  <button type="submit">Register</button>
  <a href="login.php">Already have account <p>Sign in </p></a>
</form>
</body>
</html>
