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
    <title>Main Admin Panel</title>
</head>
<body>
<div class="container">
<div>
        <form class="text" action="index.php" method="POST">
            <button type="submit">Back to main page</button>
        </form>
    </div>
    <br><br>
    <h2>Administrative Tasks</h2>
    <div>
        <form class="text" action="index.php" method="POST">
            <button type="submit">Modify user accounts</button>
        </form>
    </div>
    <div>
        <form class="text" action="index.php" method="POST">
            <button type="submit">Modify products in database</button>
        </form>
    </div>
</div>

<?php
require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h1>ALL USER DATA</h1>";
    $stmt = $conn->prepare('SELECT * FROM users ORDER BY id DESC');
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['id']."     ";
            echo $row['uname']."     ";
            echo $row['upass']."     ";
            echo $row['ubank']."     ";
            echo $row['realname']."     ";
            echo $row['realsurname']."     ";
            echo $row['uemail']."     ";
            echo "<br><br>";
        }
    }

    echo "<h1>ALL PRODUCTS DATA</h1>";
    $stmt = $conn->prepare('SELECT * FROM prod ORDER BY put_date DESC');
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['id']."     ";
            echo $row['price']."     ";
            echo $row['name']."     ";
            echo $row['description']."     ";
            echo $row['user_id']."     ";
            echo $row['amount']."     ";
            echo $row['put_date']."     ";
            echo "<br><br>";
        }
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
</body>
</html>