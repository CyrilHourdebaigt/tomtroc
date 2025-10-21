<?php
require_once __DIR__ . '/Database.php';

class User
{
    private $db;

    // Connexion à la base
    public function __construct()
    {
        $db = new Database();
        $this->db = $db->getConnection();
    }

    // Récupère un utilisateur à partir de son email
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare(
            "
            SELECT * 
            FROM users 
            WHERE email = :email"
        );
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    // Créer un nouvel utilisateur
    public function create($username, $email, $password)
    {
        $stmt = $this->db->prepare(
            "
            INSERT INTO users (username, email, password) 
            VALUES (:username, :email, :password)"
        );
        // password_hash() chiffre le mot de passe avant de le stocker
        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    // Mettre à jour l'avatar de l'utilisateur
    public function updateAvatar($userId, $avatarPath)
    {
        $stmt = $this->db->prepare(
            "
            UPDATE users 
            SET avatar = :avatar 
            WHERE id = :id"
        );
        $stmt->execute([
            'avatar' => $avatarPath,
            'id' => $userId
        ]);
    }

    // Récupère un utilisateur par son id
    public function findById($id)
    {
        $stmt = $this->db->prepare(
            "
            SELECT * 
            FROM users 
            WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
