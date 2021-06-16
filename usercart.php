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
    <title>Modify Users</title>
    <style>
        .content__list {
            margin-top: 50px;
            margin-left: 10%;
            margin-right: 10%;
        }

        input, button[type=submit] {
            border: 0;
            background: none;
            display: block;
            margin: 20px auto;
            text-align: center;
            padding: 12px;
            border-radius: 25px;
            border: 2px solid white;
            outline: none;
            color: white;
            transition: .2s;
            width: 200px;
        }

        .btn_delete [type=submit]:hover {
            width: 250px;
            background-color: red;
        }
        
        h2 {
            font: 400 40px/1.5 Helvetica, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        li {
            font: 200 20px/1.5 Helvetica, Verdana, sans-serif;
            border-bottom: 1px solid #ccc;
        }

        li:last-child {
            border: none;
        }
        .product_wrapper{
            border-radius: 25px;
            border: 2px solid white;
            padding: 20px;
            margin: 30px;
            display: inline-table;
            margin: 30px;
        }
    </style>
</head>
<body>
<div>
    <form class="text" action="userpage.php" method="POST">
        <button type="submit">Back to User Page</button>
    </form>

    <div class="content__list">
        <ul id="list"></ul>
    </div>

</div>
<?php

require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_SESSION['mess'])){
        echo $_SESSION['mess']."<br><br>";
        unset($_SESSION['mess']);
    }
    $stmt = $conn->prepare('SELECT * FROM cart WHERE userid = ?');
    $stmt->execute(array($_SESSION['id']));
    if($stmt->rowCount() > 0) {
        $cartsum = 0;
        echo "Your cart items: <br><br>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stmt2 = $conn->prepare('SELECT * FROM prod WHERE id = ?');
            $stmt2->execute(array($row['prodid']));
            if($stmt2->rowCount() > 0) {
                while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='product_wrapper'>";
                    echo "Product's ID: ".$row2['id']."<br>";
                    echo "Price per item: ".$row2['price']." ZŁ<br>";
                    echo "Product's Name: ".$row2['name']."<br>";
                    echo "<form class='text' action='cartdeleteitem.php' method='POST'>";
                    echo "<input type='hidden' id='PID' name='PID' value=".$row2['id'].">";
                    echo "<button class='btn_delete' type='submit'>Delete from cart</button>";
                    echo "</form>";
                    echo "</div>";
                    $cartsum += floatval($row2['price']);
                }
            }
        }
        echo "<div>";
        echo "Sum to be paid: <b>".$cartsum." Zł</b><br>";
        echo "<button class='btn_delete' type='submit'>Payment</button>";
        echo "<div> ";
        echo "<form class='text' action='index.php' method='POST'>";
        echo "<button type='submit'>Go back</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
    else {
        echo "<div> ";
        echo "Your cart is empty!";
        echo "<form class='text' action='index.php' method='POST'>";
        echo "<button type='submit'>Go back</button>";
        echo "</form>";
        echo "</div>";
    }
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

</script>
</body>
</html>