<?php 
session_start();
include('connexionBdd.php');

class EditPrenom 
{
    protected $user;
    protected $prenom;
    protected $connexion;
    protected $bdd;
    
    public function __construct($newUser, $newPrenom)
    {
        $this->user = $newUser;
        $this->prenom = $newPrenom;
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }

    public function editPrenom()
    {
        //echo $this->prenom;
        $insertprenom = $this->bdd->prepare("UPDATE user SET surname = ? WHERE id_user = ?");
        $insertprenom->execute(array($this->prenom,$this->user));    
    } 
}

class EditNom 
{
    protected $user;
    protected $nom;
    protected $connexion;
    protected $bdd;
    
    public function __construct($newUser, $newNom)
    {
        $this->user = $newUser;
        $this->nom = $newNom;
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }

    public function editNom()
    {
        //echo $this->nom;
        $insertnom = $this->bdd->prepare("UPDATE user SET name = ? WHERE id_user = ?");
        $insertnom->execute(array($this->nom,$this->user));    
    } 
}

class EditDate 
{
    protected $user;
    protected $dateDeNaissance;
    protected $connexion;
    protected $bdd;
    
    public function __construct($newUser, $newDN)
    {
        $this->user = $newUser;
        $this->dateDeNaissance = $newDN;
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }

    public function editAge()
    {
        //echo $this->dateDeNaissance;
        $insertage = $this->bdd->prepare("UPDATE user SET birthdate = ? WHERE id_user = ?");
        $insertage->execute(array($this->dateDeNaissance,$this->user));  
    } 
    
}

class EditPseudo 
{
    protected $user;
    protected $pseudo;
    protected $connexion;
    protected $bdd;
    
    public function __construct($newUser, $newPseudo)
    {
        $this->user = $newUser;
        $this->pseudo = $newPseudo;
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }

    public function editPseudo()
    {
        //echo $this->ville ."  ". $this->nom;
        $insertpseudo = $this->bdd->prepare("UPDATE user SET pseudo = ? WHERE id_user = ?");
        $insertpseudo->execute(array($this->pseudo,$this->user));        
    }
}

class EditMail 
{
    protected $user;
    protected $mail;
    protected $connexion;
    protected $bdd;
    
    public function __construct($newUser, $newMail)
    {
        $this->user = $newUser;
        $this->mail = $newMail;
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }

    public function editMail()
    {
        //echo $this->mail;
        $insertmail = $this->bdd->prepare("UPDATE user SET email = ? WHERE id_user = ?");
        $insertmail->execute(array($this->mail,$this->user));     
    }
}

class EditBio 
{
    protected $user;
    protected $bio;
    protected $connexion;
    protected $bdd;
    
    public function __construct($newUser, $newBio)
    {
        $this->user = $newUser;
        $this->bio = $newBio;
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }

    public function editBio()
    {
        //echo $this->bio;
        $insertbio = $this->bdd->prepare("UPDATE user SET bio = ? WHERE id_user = ?");
        $insertbio->execute(array($this->bio,$this->user));     
    }
}

class EditMdp 
{
    protected $user;
    protected $mdp;
    protected $connexion;
    protected $bdd;
    
    public function __construct($newUser, $newMdp)
    {
        $this->user = $newUser;
        $this->bio = $newMdp;
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }

    public function editMdp()
    {
        //echo $this->bio;
        $insertmdp = $this->bdd->prepare("UPDATE user SET `password` = ? WHERE id_user = ?");
        $insertmdp->execute(array($this->mdp,$this->user));     
    }
}

?>