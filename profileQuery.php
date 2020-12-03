<?php
$servername = "localhost";
$username = "admin";
$dbname = "common-database";

try {
  $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $username);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  session_start();

  $displayProfile = $connection->prepare("SELECT * FROM `user` 
  WHERE `id_user` = \"" . $_SESSION['id_user']  . "\"");
  $displayProfile->execute();
  $displayProfile = $displayProfile->fetchAll(0)[0];
  $followingCount = $connection->prepare("SELECT COUNT(`id_follower`) AS 'followingCount'
  FROM `follow` WHERE `id_follower` ='" . $_SESSION['id_user'] . "';");
  $followingCount->execute();
  $followingCount = $followingCount->fetchAll(0)[0]["followingCount"];
  $followingArray = $connection->prepare("SELECT pseudo
  FROM follow
  LEFT JOIN user
  ON follow.id_followed = user.id_user WHERE id_follower='" . $_SESSION['id_user'] . "'");
  $followingArray->execute();
  $followingArray = $followingArray->fetchAll(0);
  $followersCount = $connection->prepare("SELECT COUNT(`id_followed`) AS 'followersCount'
  FROM `follow`
  WHERE `id_followed` = '" . $_SESSION['id_user'] . "';");
  $followersCount->execute();
  $followersCount = $followersCount->fetchAll(0)[0]["followersCount"];
  $followersArray = $connection->prepare("SELECT pseudo
  FROM follow
  LEFT JOIN user ON follow.id_follower = user.id_user WHERE id_followed='" . $_SESSION['id_user'] . "'");
  $followersArray->execute();
  // $followersArray->debugDumpParams(); die;
  $followersArray = $followersArray->fetchAll(0);


} catch (PDOException $e) {
  echo $e->getMessage();
}

$connection = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tweet@cademie!</title>
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
        <a class="navbar-brand" href="index.php">Tweet@!</a>
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
              <button class="btn btn-default" type="button">
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
  <div class="container">
    <div class="row">
      <div class="col-sm-10">
        <h1 class="text-center">User profile</h1>
        <div class="row">
          <div class="col-sm-1">
          </div>
          <div class="col-sm-11">
            <?php
            echo "<h4>First name:</h4>  &emsp;<label> " . $displayProfile['name']  . "</label>
              <h4>Last name:</h4>  &emsp;<label> " . $displayProfile['surname']  . "</label>
              <h4>Bio:</h4>  &emsp;<label> " . $displayProfile['bio']  . "</label>
              <h4>Following:</h4>  &emsp;<label> " . $followingCount  . "</label>";

            if ($followingCount > 0) {
              echo " <button onclick=\"toggleElement('.div-following')\" class='btn'> View</button>
              <br><div class='well div-users div-following' style='display: none;'>";
              foreach ($followingArray as $followingKey => $followingValue) {
                echo '@' . $followingValue[0] . ', ';
              };
              echo "</div><br>";
            }

            echo "<h4>Followed:</h4>  &emsp;<label> " . $followersCount  . "</label>";

            if ($followersCount > 0) {
              echo " <button onclick=\"toggleElement('.div-followers')\" class='btn'> View</button>
              <br><div class='well div-users div-followers' style='display: none;'>";
              foreach ($followersArray as $followersKey => $followersValue) {
                echo '@' . $followersValue[0] . ', ';
              };
              echo "</div><br>";
            }

            echo "<br><br><a href='sessionDestroy.php'>
              <button class='btn btn-danger' style='margin-left: 40%;'>Logout</button></a>
              <br><br>";
            ?>
          </div>
        </div>
      </div>
      <div class="col-sm-2 well text-center">
        <p>Trending this week:</p>
        <div class="thumbnail">
          <p><strong>#Bernie<wbr>OrBust</strong></p>
          <p>Thu. 20 February 2020</p>
          <button class="btn btn-primary">Tweet</button>
        </div>
        <div class="thumbnail">
          <p><strong>#Bojack<wbr>Finale</strong></p>
          <p>Sat. 22 February 2020</p>
          <button class="btn btn-primary">Tweet</button>
        </div>
        <div class="thumbnail">
          <p><strong>#WAC<wbr>Rocks</strong></p>
          <p>Sun. 23 February 2020</p>
          <button class="btn btn-primary">Tweet</button>
        </div>
      </div>
    </div>
  </div>
  <footer class="container-fluid text-center">
    <p><span class="glyphicon glyphicon-copyright-mark"></span> Copyright of W@C 2020. Suggestions and complaints <a href="Milton.jpg">here</a>.</p>
  </footer>
</body>

</html>
