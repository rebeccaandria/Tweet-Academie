<?php
session_start();
error_reporting(0);
//echo $_SESSION['id_user']; 
// echo $_SESSION['birthdate'];
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
  <div class="container text-center">
    <div class="row">
      <div class="col-sm-10">
        <div class="row">
          <form method="POST" id="comment_form">
            <div class="col-sm-12">
              <div class="panel panel-default text-left">
                <div class="panel-body form-group">
                  <textarea class="text_content form-control" id="comment_content" name="comment_content" placeholder="Votre tweet" style="margin-bottom: 10px"></textarea>
                  <label for="tweetFile" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-picture"></span> Photo</label>
                  <a id="smiley" title="smiley" href="#" onclick="enableTxt(this)">&#128515;</a><a id="wink" title="wink" href="#" onclick="enableTxt(this)">&#128521;</a><a id="tongue" title="tongue" href="#" onclick="enableTxt(this)">&#128523;</a><a id="heartface" title="heartface" href="#" onclick="enableTxt(this)">&#128525;</a><a id="glasses" title="glasses" href="#" onclick="enableTxt(this)">&#128526;</a><a id="kiss" title="kiss" href="#" onclick="enableTxt(this)">&#128536;</a><a id="angry" title="angry" href="#" onclick="enableTxt(this)">&#128545;</a><a id="shook" title="shook" href="#" onclick="enableTxt(this)">&#128552;</a><a id="sleepy" title="sleepy" href="#" onclick="enableTxt(this)">&#128564;</a><a id="sadface" title="sadface" href="#" onclick="enableTxt(this)">&#128530;</a><a id="thumbsup" title="thumbsup" href="#" onclick="enableTxt(this)">&#128077;</a><wbr><a id="thumbsdown" title="thumbsdown" href="#" onclick="enableTxt(this)">&#128078;</a><a id="fuck" title="fuck" href="#" onclick="enableTxt(this)">&#128405;</a><a id="clap" title="clap" href="#" onclick="enableTxt(this)">&#128079;</a><a id="dead" title="dead" href="#" onclick="enableTxt(this)">&#128128;</a><a id="yass" title="yass" href="#" onclick="enableTxt(this)">&#128133;</a><a id="heart" title="heart" href="#" onclick="enableTxt(this)">&#128147;</a><a id="brokenheart" title="brokenheart" href="#" onclick="enableTxt(this)">&#128148;</a><a id="poop" title="poop" href="#" onclick="enableTxt(this)">&#128169;</a><a id="strong" title="strong" href="#" onclick="enableTxt(this)">&#128170;</a><a id="100" title="100" href="#" onclick="enableTxt(this)">&#128175;</a><a id="dollar" title="dollar" href="#" onclick="enableTxt(this)">&#128178;</a><a id="18" title="18" href="#" onclick="enableTxt(this)">&#128286;</a><a id="fire" title="fire" href="#" onclick="enableTxt(this)">&#128293;</a>
                  <script>
                    function enableTxt(elem) {
                      $('#comment_content').val($('#comment_content').val() + $(elem).html());
                    }
                  </script>
                  <input type="file" name="tweetFile" id="tweetFile" style="display: none;"></input>

                  <button type="submit" name="submit" id="submit" style="float:right" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-send"></span>
                    Tweet!
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <span id="comment_message"></span>
        <div id="display_comment"></div>
      </div>
      <div class="col-sm-2 well">
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
  <script src="tweet.js"></script>
</body>

</html>