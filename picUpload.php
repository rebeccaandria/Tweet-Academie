
<?php
$servername = "localhost";
$username = "admin";
$dbname = "common-database";
session_start();

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $username);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $avatarQuery = $connection->prepare("UPDATE `user` SET
    `profile_picture` = 'set'
    WHERE `id_user` = " . $_SESSION['id_user'] . ";");
    $avatarQuery->execute();
    $target_dir = "tweet/";
    $target_file = $target_dir . $_SESSION['id_user'] . '.png';
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["avatar"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        @unlink($target_file);
    }
    // Allow certain file formats
    if ($imageFileType != "png") {
        echo "Sorry, only PNG files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["avatar"]["name"]) . " has been uploaded.";
            header("location: editProfil.php");
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connection = null;
