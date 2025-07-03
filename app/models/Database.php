<?php

class Database
{
    private $host = 'localhost';
    private $dbname = 'tomtroc'; 
    private $username = 'root';
    private $password = '';
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;charset=utf8",
                $this->username,
                $this->password
            );
            // Activer les erreurs PDO en mode Exception
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    // Une méthode pour récupérer l'objet PDO
    public function getConnection()
    {
        return $this->pdo;
    }

    // Nouvelle méthode statique pour appel global
    public static function getConnectionStatic()
    {
        $instance = new self();
        return $instance->getConnection();
    }
}
