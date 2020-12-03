<?php
session_start();
/*$_SESSION['id_user'] = $valeur['id_user'];
        $_SESSION['name'] = $valeur['name'];
        $_SESSION['surname'] = $valeur['surname'];
        $_SESSION['pseudo'] = $valeur['pseudo'];
        $_SESSION['birthdate'] = $valeur['birthdate'];
        $_SESSION['email'] = $valeur['email'];
        $_SESSION['password'] = $valeur['password'];
        $_SESSION['bio'] = $valeur['bio'];
        echo '<pre>'.var_dump($_POST).'</pre>';*/
//include('loginQuery.php');

$bdd = new PDO('mysql:dbname=common-database;host=127.0.0.1', 'admin', 'admin');
//var_dump($_SESSION);
if (isset($_SESSION['id_user']) and !empty($_SESSION['id_user'])) {
    if (isset($_POST['envoi_message'])) {
        if (isset($_POST['destinataire'], $_POST['message']) and !empty($_POST['destinataire']) and !empty($_POST['message'])) {
            $destinataire = htmlspecialchars($_POST['destinataire']);
            $message = htmlspecialchars($_POST['message']);
            $dt = new DateTime();
            $dt = $dt->format('Y-m-d  H:i:s');
          
            $id_destinataire= $bdd->prepare('SELECT id_user FROM user WHERE pseudo = ?');
            $id_destinataire->execute(array($destinataire));
            $id_destinataire = $id_destinataire->fetch();
            //var_dump($id_destinataire);
            $id_destinataire = $id_destinataire['id_user'];

            //var_dump(array(2,$id_destinataire,$dt,$message));
            //var_dump("ok");
           
            $ins = $bdd->prepare("INSERT INTO message (id_expeditor,id_receiver,message_date,content_message) VALUES (?,?,?,?)");
            //var_dump($ins);
            //echo "test3";
            //$dt = "2010-04-02 15:28:22";
            $ins->execute(array($_SESSION['id_user'],$id_destinataire,$dt,$message));
            //var_dump("ok");

            $error= "Votre message à bien été envoyé !";
        } else {
            $error = "Veuillez compléter tous les champs !";
        }
    }
    // echo "test2";
    $destinataires = $bdd->query('SELECT pseudo FROM user ORDER BY pseudo');
    $tab = $destinataires->fetchAll();
    //var_dump($tab); ?>

<?php
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Envoi message</title>
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
          <li><a href="my_feed.php">Home</a></li>
          <li class="active"><a href="envoi.php">Messages</a></li>
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
  <div class="col-md-2">
            <section>
                <h1>Messages</h1>
            </section>

                <form method ="POST">
                    <div class = "message">
                    <label>Destinataire:</label>
                    <select name="destinataire">
                    <option disabled selected>Bonjour</option>
                        <?php foreach ($tab as $value) {?>
                        <option><?php echo $value[0]?></option>
                        <?php } ?>
                    </select>
                    <br/><br/>
                    <textarea placeholder="Votre message" name ="message"></textarea>
                        <br /><br />
                <input type ="submit" name ="envoi_message" value = "Envoyer"/>
                <br /><br />
                <?php if (isset($error)) {
        echo $error;
    } ?>
                </form>
                <a href="reception.php">Boîte de reception</a>
                </div>
</div>
        </body>
</html>
                                         

