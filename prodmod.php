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
    <style>
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
    </style>
</head>
<body>
<div>
    <form class="text" action="index.php" method="POST">
        <button type="submit">Back to User Page</button>
    </form>
</div>

<h1>ALL PRODUCTS DATA</h1>
<ul id="products-list">
</ul>
<?php
require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare('SELECT * FROM prod ORDER BY put_date DESC');
    $stmt->execute();
    $dataArray = $stmt->fetchAll();
    $dataJSON = json_encode($dataArray);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<script>


let list = document.getElementById('products-list');
var data = <?php echo $dataJSON; ?>;

for(var i=0; i<data.length; i++){
    var li = document.createElement("li");
    li.appendChild(document.createTextNode('id: ' + data[i]['id'] + data[i]['name'] + "  "+data[i]['description']+" "+data[i]['price']+" PLN"));
    var form = document.createElement("form");
    var hiddenInput = document.createElement("input");
    var button = document.createElement("input");

    form.method = "POST";
    form.action = "deleteprod.php";


    hiddenInput.setAttribute("type", "hidden");
    hiddenInput.setAttribute("id", i);
    hiddenInput.setAttribute("name", i);
    hiddenInput.setAttribute("value", data[i]['id']);
    form.appendChild(hiddenInput);

    button.setAttribute("id", i);
    button.setAttribute("type", "submit");
    button.value = "Delete";
    form.appendChild(button);
    li.appendChild(form);

    li.setAttribute("id", i);
    list.appendChild(li);
    list.appendChild(li);

}
</script>
</body>
</html>