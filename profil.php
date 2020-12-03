<?php
$servername = "localhost";
$username = "admin";
$dbname = "common-database";
error_reporting(0);

try {
  $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $username);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  session_start();

  if (isset($_GET['id'])) {
    $displayProfile = $connection->prepare("SELECT * FROM `user` 
    WHERE `pseudo` = \"" . substr($_GET['id'], 1)  . "\"");
    $displayProfile->execute();
    if ($displayProfile->rowCount() == 0) {
      echo "User not found! Click <a href=\"javascript:history.back()\">here</a> to try again.";
      die;
    }
    $displayProfile = $displayProfile->fetchAll(0)[0];
    $userId = $displayProfile['id_user'];
    if ($userId == $_SESSION['id_user']) {
      $footerButton = "<a href='sessionDestroy.php'><button class='btn btn-danger' style='margin-left: 40%;'>Logout</button></a>";
    } else {
      $followQuery = $connection->prepare("SELECT * FROM `follow`
      WHERE `id_follower` ='" . $_SESSION['id_user'] . "' AND `id_followed` ='$userId';");
      $followQuery->execute();
      if ($followQuery->rowCount() > 0) {
        $footerButton = "<a href='followQuery.php?id=%40" . $displayProfile['pseudo'] . "&action=unfollow'>
        <button class='btn' style='margin-left: 40%;'>Unfollow</button></a>";
      } else {
        $footerButton = "<a href='followQuery.php?id=%40" . $displayProfile['pseudo'] . "&action=follow'>
        <button class='btn btn-primary' style='margin-left: 40%;'>Follow</button></a>";
      }
    }
  } else {
    $userId = $_SESSION['id_user'];
    $displayProfile = $connection->prepare("SELECT * FROM `user` 
    WHERE `id_user` = \"" . $userId  . "\"");
    $displayProfile->execute();
    $displayProfile = $displayProfile->fetchAll(0)[0];
    $footerButton = "<a href='sessionDestroy.php'><button class='btn btn-danger' style='margin-left: 40%;'>Logout</button></a>";
  }

  $followingCount = $connection->prepare("SELECT COUNT(`id_follower`) AS 'followingCount'
  FROM `follow` WHERE `id_follower` ='" . $userId . "';");
  $followingCount->execute();
  $followingCount = $followingCount->fetchAll(0)[0]["followingCount"];
  $followingArray = $connection->prepare("SELECT pseudo
  FROM follow
  LEFT JOIN user
  ON follow.id_followed = user.id_user WHERE id_follower='" . $userId . "'");
  $followingArray->execute();
  $followingArray = $followingArray->fetchAll(0);
  $followersCount = $connection->prepare("SELECT COUNT(`id_followed`) AS 'followersCount'
  FROM `follow`
  WHERE `id_followed` = '" . $userId . "';");
  $followersCount->execute();
  $followersCount = $followersCount->fetchAll(0)[0]["followersCount"];
  $followersArray = $connection->prepare("SELECT pseudo
  FROM follow
  LEFT JOIN user ON follow.id_follower = user.id_user WHERE id_followed='" . $userId . "'");
  $followersArray->execute();
  // $followersArray->debugDumpParams(); die;
  $followersArray = $followersArray->fetchAll(0);
} catch (PDOException $e) {
  echo $e->getMessage();
}

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
          <li><a href="my_feed.php">Home</a></li>
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
          <li class="active"><a href="profil.php"><span class="glyphicon glyphicon-user"></span></a></li>
          <li><a href="sessionDestroy.php"><span class="glyphicon glyphicon-off"></span></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <div class="row">
      <div class="col-sm-10">
        <h1 class="text-center">@<?echo $displayProfile['pseudo'];?></h1>
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

            echo "<br><br>"
              . $footerButton .
              "<br><br><br>";
            // SELECT tweet.tweet_date,tweet.content_tweet,user.pseudo FROM user,tweet WHERE tweet.id_autor=1 AND user.id_user=1
// session_start();
$id_user = $_SESSION['id_user'];
$statement = $connection->query("SELECT tweet.tweet_date,tweet.content_tweet,user.pseudo,user.id_user,tweet.id_tweet FROM user,tweet WHERE tweet.id_autor=user.id_user AND user.id_user=". $userId . " ORDER BY tweet.id_tweet DESC");
$statement->execute();
$result = $statement->fetchAll();

$output = '';
foreach ($result as $row) {
    //var_dump($row);
    $pseudo = $row['pseudo'];
    $output .= "
    <div class='well col-sm-2'>" . (is_file("./avatar/" . $row['id_user'] . ".png") ? 
    "<img width=\"50\" height=\"50\" src=\"./avatar/" . $row['id_user'] . ".png\">" :
    "<span class=\"glyphicon glyphicon-user\"></span>") . "</div><div class='col-sm-10'>
    <form method='get' action='profil.php'>
    <div class='well tweet-content'  align='left'><div class='tweet-innerhtml'>&emsp;<b><input type='hidden' name='id' value='@$pseudo'/>
        <button class='btn btn-link' type='submit'>@$pseudo</button></b> on <i>" . $row['tweet_date'] . "</i>
    </form>
        <br>
        <div class='tweet'>" . $row['content_tweet'] . "</div><br></div><div class='buttons' style='float: right;'>
        <button class='btn btn-secondary'><span class='glyphicon glyphicon-thumbs-up'></button>
        <button class='btn btn-secondary'><span class='glyphicon glyphicon-comment'></button>
        <button class='btn btn-secondary'><span class='glyphicon glyphicon-retweet'></button></div>
        </div>
    </div>";
    //$output .= get_reply_comment($connection);
    //var_dump($output);
}
//echo "okok";
echo $output . "<script>getTheme();
function hashtag(text) {
    var repl = text.replace(
      /#(\w+)/g,
      '<a href=\"tweetQuery.php?search=%23$1\">#$1</a>'
    );
    return repl;
  }
  for (let i = 0; i < document.querySelectorAll(\".tweet-innerhtml\").length; i++) {
    document.querySelectorAll(\".tweet-innerhtml\")[i].innerHTML = hashtag(
      document.querySelectorAll(\".tweet-innerhtml\")[i].innerHTML
    );
  }    
  function arobase(text) {
    var repl = text.replace(
      /@(\w+)/g,
      '<a href=\"profil.php?id=%40$1\">@$1</a>'
    );
    return repl;
  }
  for (let i = 0; i < document.querySelectorAll(\".tweet\").length; i++) {
    document.querySelectorAll(\".tweet\")[i].innerHTML = arobase(
      document.querySelectorAll(\".tweet\")[i].innerHTML
    );
  }      
</script><br><br>";
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