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
<ul id="products-list">
    <li>Test</li>
</ul>
<?php
require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<div>";
    echo "<h1>ALL PRODUCTS DATA</h1>";
    $stmt = $conn->prepare('SELECT * FROM prod ORDER BY put_date DESC');
    $stmt->execute();
    $dataArray = $stmt->fetchAll();
    $dataJSON = json_encode($dataArray);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<script>
const element = document.getElementById('products-list');

var data = <?php echo $dataJSON; ?>;
console.log( data );
console.log( data[0] );
for(var i=0; i<data.length; i++){
    console.log('test; ');
    console.log(data[i]);
    console.log(data[i]['name']);
    element.appendChild('some',li);

}

</script>
</body>
</html>