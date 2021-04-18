<?php
session_start();
if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true)) {
    header('Location: userpage.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="styles/loginStyle.css">
</head>
<body>
  <form class="container" action="session.php" method="POST">
  <h2>Sign in</h2>
  <input type="text" name="inlogin" placeholder="Enter Username">
  <input type="password" name="inpass" placeholder="Enter Password">
  <button type="submit">Login</button>
  <?php
	if(isset($_SESSION['err']))	
    echo $_SESSION['err']."<br>";
  if(isset($_SESSION['mess']))	
    echo $_SESSION['mess']."<br>";
  ?>
  <a href="register.php">Don't have account Yet <p>Sign up</p></a>
</form>
</body>
</html>
