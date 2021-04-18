<?php
session_start();
if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true)) {
    session_destroy();
    session_write_close();
    header('Location: index.php');
    exit();
}
?>