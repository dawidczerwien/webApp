<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false)) {
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
    <title>Add Product</title>
</head>
<body>
    <form class="container" action="addproductcheck.php" method="POST">
        <h2>Add new product</h2>
        <input type="text" name="inname" placeholder="Enter product name">
        <input type="text" name="indesc" placeholder="Enter product description">
        <input type="text" name="inprice" placeholder="Enter product price (per one)">
        <input type="text" name="innumber" placeholder="Product quantity">
        <?php
            if(isset($_SESSION['err']))	{
                echo $_SESSION['err']."<br>";
            unset( $_SESSION['err']);
        }
        ?>
        <button type="submit">Add new!</button>
    </form>
</body>
</html>