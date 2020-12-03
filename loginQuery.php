<?php

$servername = "localhost";
$username = "admin";
$dbname = "common-database";
$pseudo = $_POST['username'];
$password = hash('ripemd160', $_POST['password']."vive le projet tweet_academy");

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $username);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $loginQuery = $connection->prepare("SELECT *
    FROM `user`
    WHERE `pseudo` = '$pseudo' AND `password` = '$password';");
    $loginQuery->execute();
    $query = $loginQuery->rowCount();
        if ($query >= 1) {
            session_start();
            $query = $loginQuery->fetch();
            $_SESSION['id_user'] = $query['id_user'];
            $_SESSION['name'] = $query['name'];
            $_SESSION['surname'] = $query['surname'];
            $_SESSION['pseudo'] = $query['pseudo'];
            $_SESSION['birthdate'] = $query['birthdate'];
            $_SESSION['email'] = $query['email'];
            $_SESSION['password'] = $query['password'];
            $_SESSION['bio'] = $query['bio'];
            header("location: my_feed.php?id=".$_SESSION['id_user']);
        } else {
            header("location: login.php");
        }
    }

    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

$connection = null;
