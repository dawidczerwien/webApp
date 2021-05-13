<?php
session_start();
if ((!isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==false) && ($_SESSION['role'] != "Admin") ) {
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
    <title>Modify Products</title>
</head>
<body>
<div>
    <form class="text" action="index.php" method="POST">
        <button type="submit">Back to User Page</button>
    </form>
</div>
<?php
require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<div>";
    echo "<h1>ALL PRODUCTS DATA</h1>";
    $stmt = $conn->prepare('SELECT * FROM prod ORDER BY put_date DESC');
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "ID:".$row['id']."     ";
            echo "User ID:".$row['user_id']."     ";
            echo "Price:".$row['price']."     ";
            echo "Amount:".$row['amount']."     ";
            echo "Product Name:".$row['name']."     ";
            echo "Description:".$row['description']."     ";
            echo "Put date:".$row['put_date']."     ";
            echo "<div> ";
            echo "<form class='text' action='index.php' method='POST'>";
            echo "<button type='submit'>Modify</button>";
            echo "</form>";
            echo "</div>";
            echo "=========================================";
            echo "<br><br>";
        }
    }
    echo "</div>";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
</body>
</html>