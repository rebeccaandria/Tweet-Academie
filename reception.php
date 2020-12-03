<?php
session_start();

$bdd = new PDO('mysql:dbname=common-database;host=127.0.0.1', 'admin', 'admin');


if (isset($_SESSION['id_user']) and !empty($_SESSION['id_user'])) {
    $msg=$bdd->prepare('SELECT * FROM message WHERE id_receiver = ? ORDER BY message_date DESC');
    $msg->execute(array($_SESSION['id_user']));
    $msg_nbr = $msg->rowCount();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Boite de reception</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
  <script src="script.js"></script>
  
</head>

<body>
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="my_feed.php">Tweet@!</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="my_feed.php">Home</a></li>
          <li><a href="envoi.php">Messages</a></li>
          <li><a href="#" onclick="switchTheme()">Theme</a></li>
        </ul>
        <form action="tweetQuery.php" class="navbar-form navbar-right" role="search" method="GET">
          <div class="form-group input-group">
            <input type="text" class="form-control" placeholder="Search.." name="search">
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="editProfil.php"><span class="glyphicon glyphicon-edit"></span></a></li>
          <li><a href="profil.php"><span class="glyphicon glyphicon-user"></span></a></li>
          <li><a href="sessionDestroy.php"><span class="glyphicon glyphicon-off"></span></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="col-md-6">
            <a href="envoi.php">Nouveau message</a><br /><br /><br />
            <h3>Votre boîte de reception :</h3>
        <?php
        if($msg_nbr == 0) { echo "Vous n'avez aucun message..."; }
        while($m = $msg->fetch()) {
            $p_exp = $bdd->prepare('SELECT pseudo FROM user WHERE id_user = ?');
            $p_exp->execute(array($m['id_expeditor']));
            $p_exp = $p_exp->fetch();
            $p_exp = $p_exp['pseudo'];
        ?>
        Le <?= $m['message_date'] ?><br /><b><?= $p_exp ?></b> vous a envoyé : <br />
        <?= $m['content_message'] ?><br /><br />

<?php
}
?>
  </div>

        </body>
</html>
