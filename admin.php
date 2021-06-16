<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false) && ($_SESSION['role'] != "Admin") ) {
    $_SESSION['err'] = "You have to log in first! (as admin)";
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/loginStyle.css">
    <title>Main Admin Panel</title>
</head>
<body>
<div class="container">
    <h2>Administrative Tasks</h2>
    <div>
        <form class="text" action="usermod.php" method="POST">
            <button type="submit">Deactivate user accounts</button>
        </form>
    </div>
    <div>
        <form class="text" action="prodmod.php" method="POST">
            <button type="submit">Delete products</button>
        </form>
    </div>

    <br><br>
    
    <h2>User Tasks</h2>
    <div>
        <form class="text" action="userpage.php" method="POST">
            <button type="submit">Back to User Page</button>
        </form>
    </div>
    <div>
        <form class="text" action="index.php" method="POST">
            <button type="submit">Back to Main Page</button>
        </form>
    </div>
</div>
</body>
</html>