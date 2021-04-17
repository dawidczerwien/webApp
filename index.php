<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tytuł strony</title>
        <link rel="stylesheet" type="text/css" href="styles/style.css">
    </head>

    <body>
        <div id="header">
            <h1>KSIĄŻKI</h1>
            <div id="loginIcon">
                <a href="login.php"><p>LOGIN</p></a>
            </div>
        </div>
        <div id="content">
        <?php
        session_start();
        require_once "connection.php";
        try
        {
            $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('SELECT * FROM prod');
            $stmt->execute();
            $outcome = $stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0)
            {
                while ($row = $outcome)
                {
                    echo "product: ";
                    echo $row['name'];
                    echo "<br>";
                }
            }
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
        ?>
        </div>
        
        
    </body>
</html>
