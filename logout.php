<?php
session_start();
if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true)) {
    session_abort();
    header('Location: index.php');
    exit();
}
?>