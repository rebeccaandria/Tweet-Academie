<?php
// SELECT tweet.tweet_date,tweet.content_tweet,user.pseudo FROM user,tweet WHERE tweet.id_autor=1 AND user.id_user=1
session_start();
error_reporting(0);
$id_user = $_SESSION['id_user'];


$servername = "localhost";
$username = "admin";
$dbname = "common-database";
$connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $username);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$ifFollowers = $connect->prepare("SELECT id_followed FROM follow LEFT JOIN user ON follow.id_followed = user.id_user WHERE id_follower='" . $_SESSION['id_user'] . "';");
$ifFollowers->execute();

if ($ifFollowers->rowCount() > 0) {
  $followersID = "";
  $ifFollowers = $ifFollowers->fetchAll();
  foreach ($ifFollowers as $ifFollower) {
    $followersID = $followersID . ($ifFollower[0] . ", ");
  }

  $statement = $connect->query("SELECT * FROM user LEFT JOIN tweet ON tweet.id_autor=user.id_user 
    WHERE `id_autor` IN (" . $followersID . $_SESSION['id_user'] .  ") ORDER BY tweet.id_tweet DESC");
  $statement->execute();
  $result = $statement->fetchAll();
} else {
  $statement = $connect->query("SELECT tweet.tweet_date,tweet.content_tweet,user.pseudo,tweet.id_tweet, user.id_user FROM user,tweet WHERE tweet.id_autor=user.id_user ORDER BY tweet.id_tweet DESC");
  $statement->execute();
  $result = $statement->fetchAll();
}

$output = '';
foreach ($result as $row) {
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
  //$output .= get_reply_comment($connect);
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
</script>";
