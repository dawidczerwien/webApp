<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false)) {
    $_SESSION['err'] = "You have to log in first!";
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="styles/loginStyle.css">
</head>
<body>
    <div class="container">
        <div>
        <?php
        echo "<h2>Logged in as ".$_SESSION['uname']."<h2><br>";
        echo $_SESSION['realname'].$_SESSION['realsurname']."<br>";
        echo "Your account's balance is: ".$_SESSION['ubank']."<br>";
        ?>
        </div>
        <br><br>
    <div>
        <form class="text" action="index.php" method="POST">
            <button type="submit">Main Page</button>
        </form>
    </div>
    <?php 
        if  ($_SESSION['role'] == "Admin") {
            echo "<div> ";
            echo "<form class='text' action='admin.php' method='POST'>";
            echo "<button type='submit'>Admin Page</button>";
            echo "</form>";
            echo "</div>";
        }
    ?>
    <div>
    <?php
	if(isset($_SESSION['err']))	{
		echo $_SESSION['err']."<br>";
    unset( $_SESSION['err']);
    }
    if(isset($_SESSION['mess'])){
        echo $_SESSION['mess']."<br>";
        unset($_SESSION['mess']);
    }
    ?>
        <form class="text" action="addproduct.php" method="POST">
            <button type="submit">Add product for sale</button>
        </form>
    </div>
    <div>
        <form class="text" action="usercart.php" method="POST">
            <button type="submit">Your cart</button>
        </form>
    </div>
    <div>
        <form class="text" action="logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </div>
    </div>
</body>
</html>