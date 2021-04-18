<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Online Shop</title>
        <link rel="stylesheet" type="text/css" href="styles/style.css">
    </head>

    <body>
        <div id="header">
            <h1>Products</h1>
            <div id="loginIcon">
            <?php
            session_start();
            if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true)) {
                echo '<p>Logged in as:';
                echo $_SESSION['uname'];
                echo '</p><br>';
                echo '<a href="logout.php"><p>LOGOUT</p></a>';
            } else {
                echo '<a href="login.php"><p>LOGIN</p></a>';
            }
            ?>
            </div>
        </div>
        <div id="content">
        <?php
        require_once "connection.php";
        try {
            $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('SELECT * FROM prod ORDER BY put_date DESC');
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='product'>";
                    echo "<h2>";
                    echo $row['name'];
                    echo "</h2>";
                    echo "<p>";
                    echo $row['price'];
                    echo "<p>";
                    echo "</div>";
                }
            }
        }
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        ?>
        </div>
        
        
    </body>
</html>
