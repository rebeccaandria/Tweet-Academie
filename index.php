<?php
session_start();

if (isset($_SESSION['id_user'])) {
    header("location: my_feed.php");
}

else {
    header("location: login.php");
}