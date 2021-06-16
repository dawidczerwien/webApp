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

        input[type=submit]:hover {
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
    </style>
</head>
<body>
<div>
    <form class="text" action="admin.php" method="POST">
        <input type="submit" value="Back to admin page"></input>
    </form>

    <div class="content__list">
        <ul id="list"></ul>
    </div>
</div>
<h3>ALL USERS DATA</h3>
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
let list = document.getElementById('list');
<?php
if(isset($_SESSION['mess'])){
    echo $_SESSION['mess'];
    unset($_SESSION['mess']);
}
?>
for(var i=0; i<data.length; i++){

    var li = document.createElement("li");
            li.appendChild(document.createTextNode('id: ' + data[i]['id'] +" "+ data[i]['uname'] + "  "+data[i]['email']+" role: "+data[i]['role']+" "));
            var form = document.createElement("form");
            var hiddenInput = document.createElement("input");
            var button = document.createElement("input");

            form.method = "POST";
            form.action = "userban.php";


            hiddenInput.setAttribute("type", "hidden");
            hiddenInput.setAttribute("id", "id");
            hiddenInput.setAttribute("name", "id");
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