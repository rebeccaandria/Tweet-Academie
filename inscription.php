<?php
include('class/inscription.class.php');

if (isset($_POST['forminscription'])) {

  $Nom = htmlspecialchars($_POST['nom']);
  $Prenom = htmlspecialchars($_POST['prenom']);
  $Pseudo = htmlspecialchars($_POST['pseudo']);
  $Date = $_POST['date'];
  $Mail = htmlspecialchars($_POST['mail']);
  $Mail2 = htmlspecialchars($_POST['mail2']);
  $Mdp = hash('ripemd160', $_POST['mdp']."vive le projet tweet_academy");
  $Mdp2 = hash('ripemd160', $_POST['mdp2']."vive le projet tweet_academy");

  //echo "D: ".$Date.", le S: ".$Pseudo.", Mdp : ".$Mdp.", NOM : ".$Nom.", P : ".$Prenom. ", Mail : ".$Mail;

  if (isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['date']) and isset($_POST['pseudo']) and isset($_POST['mail']) and isset($_POST['mail2']) and isset($_POST['mdp']) and isset($_POST['mdp2'])) {
    if ($Nom != '' && $Prenom != "" && $Date != "" && $Pseudo != "") {
      if ($Mail == $Mail2) {
        if (filter_var($Mail, FILTER_VALIDATE_EMAIL)) {
          if ($Mdp == $Mdp2) {
            $nouvelleInscription = new Inscription($Nom, $Prenom, $Mail, $Date, $Pseudo, $Mdp);
            if ($nouvelleInscription->checkEmail($Mail)) {
                if($nouvelleInscription->checkPseudo($Pseudo)) {
                  $nouvelleInscription->insert();
                  $succes = "<font color='green'><strong>Success!</strong> Votre inscription à bien été validé.</font>";
                } else {
                  $error = $nouvelleInscription->error('Pseudo déja existant !');
                }
            } else {
              $error = $nouvelleInscription->error('Mail déja existant !');
            }
            // echo "D: ".$Date.", le S: ".$Pseudo.", Mdp : ".$Mdp.", NOM : ".$Nom.", P : ".$Prenom. ", Mail : ".$Mail;
          } else {
            $error = "Vos mot de passe ne correspondent pas !";
          }
        }
      } else {
        $error = "Vos adresses mail ne correspondent pas !";
      }
    } else {
      $error = "Veuillez remplir les champs !";
    }
  }
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
        <a class="navbar-brand" href="#">Tweet@!</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Join us</a></li>
          <li><a href="login.php">Log in</a></li>
          <li><a href="#" onclick="switchTheme()">Theme</a></li>
        </ul>
        <form class="navbar-form navbar-right" role="search">
          <div class="form-group input-group">
            <input type="text" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
        </form>
      </div>
    </div>
  </nav>
  <div class="container text-center">
    <div class="row">
      <div class="col-sm-10">
        <div class="row">
          <div class="col-sm-12">
            <div id="inscription">
              <h1 class="t_inscription">Welcome aboard!</h1><br>
              <form method="POST" action="">
                <table class="form_inscription">
                  <tr>
                    <td align="right"><label for="nom">Nom :&ThickSpace;</label></td>
                    <td><input type="text" placeholder="Votre nom" name="nom"></td>
                  </tr>

                  <tr>
                    <td align="right"><label for="prenom">Prenom :&ThickSpace;</label></td>
                    <td><input type="text" placeholder="Votre prenom" name="prenom"></td>
                  </tr>

                  <tr>
                    <td align="right"><label for="pseudo">Pseudo :&ThickSpace;</label></td>
                    <td><input type="text" placeholder="Votre pseudo" name="pseudo"></td>
                  </tr>

                  <tr>
                    <td align="right"><label for="date">Date de naissance :&ThickSpace;</label></td>
                    <td><input type="date" class="start" name="date" min="1960-01-01" max="2020-12-31"></td>
                  </tr>

                  <tr>
                    <td align="right"><label for="mail">Mail :&ThickSpace;</label></td>
                    <td><input type="email" placeholder="Votre mail" name="mail"></td>
                  </tr>

                  <tr>
                    <td align="right"><label for="mail2">Confirmation du mail :&ThickSpace;</label></td>
                    <td><input type="email" placeholder="Confirmez votre mail" name="mail2"></td>
                  </tr>

                  <tr>
                    <td align="right"><label for="mdp">Mot de passe :&ThickSpace;</label></td>
                    <td><input type="password" placeholder="Votre mot de passe" name="mdp"></td>
                  </tr>

                  <tr>
                    <td align="right"><label for="mdp2">Confirmation du mot de passe :&ThickSpace;</label></td>
                    <td><input type="password" placeholder="Votre mot de passe" name="mdp2"></td>
                  </tr>
                </table><br><br>

                <button type="submit" name="forminscription" class="btn submit_inscription">Valider</button>
                <br><br>
                <section id="error"><?php error_reporting(0); 
                echo $error;
                                    echo $succes; ?></section>
            </div>
          </div>
        </div>
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
</body>

</html>
