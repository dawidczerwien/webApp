<?php

echo "Logged in as ".$_SESSION['ulogin']."<br><br>";
echo "Hi ".$_SESSION['realname'].$_SESSION['realsurname']."<br>";
echo "Your account's balance is".$_SESSION['ubank']."<br>";

?>