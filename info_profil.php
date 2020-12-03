<?php 
try { 
    $user = 'admin';
    $mdp = "admin";
    $bdd = "common-database";

    $pdo = new PDO  ('mysql:host=127.0.0.1;dbname='.$bdd, $user, $mdp);
}  catch(PDOException $e) {
    echo 'Error : ' . $e->getMessage() . PHP_EOL;
}
//echo $_GET['pseudo'];
    $selectPseudo = $_GET['pseudo'];
    $answerProfil = $pdo->prepare("SELECT * from user WHERE pseudo = '$selectPseudo'");
    $answerProfil->execute();
    $answerTweet = $pdo->prepare("SELECT tweet.tweet_date,tweet.content_tweet,user.pseudo,tweet.id_tweet FROM user,tweet WHERE user.pseudo='$selectPseudo'AND user.id_user=tweet.id_autor ORDER BY tweet.tweet_date DESC");
    $answerTweet->execute();
    foreach($answerProfil as $key) {
        //var_dump($key);
    $pseudo = $key['pseudo'];
    $name = $key['name'];
    $surname = $key['surname'];
    $bio = $key['bio'];
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
        <h1 class="text-center"><?php echo ucfirst($pseudo);?></h1>
        <div class="row">
          <div class="col-sm-1">
          </div>
          <div class="col-sm-11">
            <h4>First name:</h4>  &emsp;<label><?php echo ucfirst($name);?> </label>
              <h4>Last name:</h4>  &emsp;<label> <?php echo ucfirst($surname);?></label>
              <h4>Bio:</h4>  &emsp;<label> <?php if ($bio != NULL) {echo $bio;} } ?></label>
              <h4>Following:</h4>  &emsp;<label> 0</label><h4>Followed:</h4>  &emsp;<label> 0</label><br><br>
            <?php
              foreach($answerTweet as $row)
                {
                echo "
                <div class='col-sm-9'>
                <form method='get' action='info_profil.php'>
                    <div class='well'>By <b>".$row['pseudo']."</b> on <i>".$row['tweet_date']."</i>
                </form>
                    <br><br>
                    ".$row['content_tweet']."
                    </div>
                    <button class='btn'><span class='glyphicon glyphicon-thumbs-up'></button>
                    <button class='btn'><span class='glyphicon glyphicon-retweet'></button><br>
                </div>"; 
                }
                ?>
              <a href='sessionDestroy.php'><button class='btn btn-danger' style='margin-left: 40%;'>Logout</button></a>
              <br><br>
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
