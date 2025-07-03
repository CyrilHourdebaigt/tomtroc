<?php
require_once __DIR__ . '/Database.php';

class User {
    private $db;

    public function __construct() {
        $db = new Database();
        $this->db = $db->getConnection();
    }

    // Méthode pour trouver un utilisateur
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    // Méthode pour créer un nouvel utilisateur
    public function create($username, $email, $password) {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    // Méthode pour mettre à jour l'avatar de l'utilisateur
    public function updateAvatar($userId, $avatarPath) {
        $pdo = Database::getConnectionStatic();

        $stmt = $pdo->prepare("UPDATE users SET avatar = :avatar WHERE id = :id");
        $stmt->execute([
            'avatar' => $avatarPath,
            'id' => $userId
        ]);
    }

    public function findById($id) {
        $db = new Database();
        $pdo = $db->getConnection();
    
        $query = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    

}
?>