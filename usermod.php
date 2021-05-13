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
    <title>Modify Users</title>
</head>
<body>
<?php
require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<div>";
    echo "<h1>ALL USER DATA</h1>";
    $stmt = $conn->prepare('SELECT * FROM users ORDER BY id DESC');
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "ID:".$row['id']."     ";
            echo "Login:".$row['uname']."     ";
            echo "Role:".$row['role']."     ";
            echo "Balance:".$row['ubank']."     ";
            echo "Name:".$row['realname']."     ";
            echo "Surname:".$row['realsurname']."     ";
            echo "Email:".$row['uemail']."     ";
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