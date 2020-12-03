<?php
include('connexionBdd.php');

class Inscription
{
    protected $nom;
    protected $prenom;
    protected $pseudo;
    protected $birthDate;
    protected $mail;
    protected $motDePass;
    protected $connexion;
    protected $bdd;
    
    public function __construct($newNom, $newPrenom, $newMail, $newDN, $newPseudo, $newMDP)
    {
        $this->nom = $newNom;
        $this->prenom = $newPrenom;
        $this->birthDate = $newDN;
        $this->pseudo = $newPseudo;
        $this->mail = $newMail;
        $this->motDePass = $newMDP;
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }
    
    public function insert()
    {
        // echo $this->mail."<br>";
        // echo $this->pseudo."<br>";
        // echo $this->nom."<br>".$this->motDePass."<br>".$this->birthDate."<br>";
        $query = $this->bdd->prepare("INSERT INTO `user` (`name`, `surname`, `pseudo`, `birthdate`, `email`, `password`, `subscribe_date`)
        VALUES(?,?,?,?,?,?,now())");
        $query->execute(array(
            $this->nom,
            $this->prenom,
            $this->pseudo,
            $this->birthDate,
            $this->mail,
            $this->motDePass
        ));
    }

    public function checkEmail($email)
    {
        $check = $this->bdd->prepare('SELECT email FROM user WHERE email=?');
        $check->execute(array($email));

        if ($check->rowCount() >= 1) {
            return false;
        } else {
            return true;
        }
    }
    
    public function checkPseudo($pseudo)
    {
        $check = $this->bdd->prepare('SELECT pseudo FROM user WHERE pseudo=?');
        $check->execute(array($pseudo));

        if ($check->rowCount() >= 1) {
            return false;
        } else {
            return true;
        }
    }

    public function error($msg)
    {
        return "<font color='FF0000'><strong>Error! </strong>".$msg."</font>";
    }

}
