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
                echo '<p>Logged in as:  ';
                echo "<b>".$_SESSION['uname']."</b>";
                echo '</p>';
                echo '<a href="logout.php"><p>LOGOUT</p></a>';
                echo '<a href="userpage.php"><p>USER PAGE</p></a>';
            } else {
                echo '<a href="login.php"><p>LOGIN</p></a>';
            }
            ?>
            </div>
        </div>
        <div id="content">
        <div id="cards">


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
        
        <form>
            <input type="text" id="search_input" onchange="filter(this)">
        </form>

        <script>
        var data = <?php echo $dataJSON; ?>;
        let cards = document.getElementById('cards');
        
        function filter(el){
            console.log(el.value);

        }
        for(var i=0; i<data.length; i++){
            cards.innerHTML += ` 
            <div class='card'>
            <div class='items_wrapper'>
                <div class='photo'><img src='https://knowledgebanksociety.com/wp-content/uploads/2017/11/book-image-9.jpg'></div>
                
                <div class='title'>${data[i].name}</div>
                <div class='description'>${data[i].description}</div>
                <div class='price'>${data[i].price}00 PLN</div>
                <div class='price'>${data[i].put_date}</div>
                
                <form class='text' action='cartadd.php' method='POST'>
                <input type='hidden' id='PID' name='PID' value=${data[i].id}>
                <button id='btn_cart' type='submit'>Add to cart</button>
                </form>
                    
                </div>
            </div>
            `
        

}

        </script>

        
        <?php
        /*
        require_once "connection.php";
        try {
            $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('SELECT * FROM prod ORDER BY put_date DESC');
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='card'>";
                    echo "<div class='items_wrapper'>";
                    echo "<div class='photo'><img src='https://knowledgebanksociety.com/wp-content/uploads/2017/11/book-image-9.jpg'></div>";
                    echo "<div class='title'>".$row['name']."</div>";
                    echo "<div class='description'>".$row['description']."</div>";
                    echo "<div class='price'>".$row['price'].".00 PLN</div>";
                    echo "<div class='price'>".$row['put_date']."</div>";
                    if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true)) {
                        echo "<form class='text' action='cartadd.php' method='POST'>";
                        echo "<input type='hidden' id='PID' name='PID' value=".$row['id'].">";
                        echo "<button id='btn_cart' type='submit'>Add to cart</button>";
                        echo "</form>";
                    }
                    echo "</div>";
                    echo "</div>";
                }
            }
        }
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        */
        ?>
        </div>
        </div>
    </body>
</html>
