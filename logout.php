<?php
session_start();
if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true))
{
    unset($_SESSION['loggedin']);
    header('Location: index.php');
    exit();
}
?>