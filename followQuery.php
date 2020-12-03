<?php

$servername = "localhost";
$username = "admin";
$dbname = "common-database";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $username);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    session_start();
    $displayProfile = $connection->prepare("SELECT * FROM `user` 
    WHERE `pseudo` = \"" . substr($_GET['id'], 1)  . "\"");
    $displayProfile->execute();
    $displayProfile = $displayProfile->fetchAll(0)[0];
    $userId = $displayProfile['id_user'];
    if ($_GET['action'] == "unfollow") {
        $followQuery = $connection->prepare("DELETE FROM `follow`
        WHERE `id_follower` ='" . $_SESSION['id_user'] . "' AND `id_followed` ='$userId';");
        $followQuery->execute();
    }
    elseif ($_GET['action'] == "follow") {
        $followQuery = $connection->prepare("INSERT INTO `follow` (`id_follower`, `id_followed`)
        VALUES ('" . $_SESSION['id_user'] . "', '" . $userId . "');");
        $followQuery->execute();
    }
    header("location: profil.php?id=%40" . $displayProfile['pseudo']);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
