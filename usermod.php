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
<div>
    <form class="text" action="index.php" method="POST">
        <button type="submit">Back to User Page</button>
    </form>

    <ul id="products-list">

</div>
<?php
require_once "connection.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<div>";
    echo "<h1>ALL USER DATA</h1>";
    $stmt = $conn->prepare('SELECT * FROM users ORDER BY id DESC');
    $stmt->execute();
    $dataArray = $stmt->fetchAll();
    $dataJSON = json_encode($dataArray);
    

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<script>
var data = <?php echo $dataJSON; ?>;
let list = document.getElementById('products-list');

for(var i=0; i<data.length; i++){

    var li = document.createElement("li");
            li.appendChild(document.createTextNode('id: ' + data[i]['id'] +" "+ data[i]['uname'] + "  "+data[i]['email']+" role: "+data[i]['role']+" "));
            var form = document.createElement("form");
            var hiddenInput = document.createElement("input");
            var button = document.createElement("input");

            form.method = "POST";
            form.action = "userban.php";


            hiddenInput.setAttribute("type", "hidden");
            hiddenInput.setAttribute("id", i);
            hiddenInput.setAttribute("name", i);
            hiddenInput.setAttribute("value", data[i]['id']);
            form.appendChild(hiddenInput);

            button.setAttribute("id", i);
            button.setAttribute("type", "submit");
            button.value = "Deactivate accout";
            form.appendChild(button);
            li.appendChild(form);
            li.setAttribute("id", i);
            list.appendChild(li);
            list.appendChild(li);

}
</script>
</body>
</html>