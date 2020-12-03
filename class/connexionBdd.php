<?php

class Connexion
{
    protected $bdd;
    public function __construct()
    {
        try {
            $this->bdd = new PDO('mysql:dbname=common-database;host=127.0.0.1', 'admin', 'admin');
        } catch (Exception $e) {
            die('Connexion échoué :' . $e->getMessage());
        }
    }

    public function getDB()
    {
        return $this->bdd;
    }
}
?>