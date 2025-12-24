<?php

// Le Manager s'occupe UNIQUEMENT des requêtes SQL.

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../entities/UserEntity.php';

class UserManager
{
    // On stocke la connexion PDO ici pour réutiliser la même connexion
    private PDO $db;

    // Constructeur : on récupère la connexion à la base via Database
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Trouver un utilisateur par son email
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM users
            WHERE email = :email
        ");

        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    // Trouver un utilisateur par son id
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM users
            WHERE id = :id
        ");

        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    // Créer un nouvel utilisateur
    public function create(string $username, string $email, string $password): bool
    {
        // On hash le mot de passe AVANT de le stocker en base
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("
            INSERT INTO users (username, email, password)
            VALUES (:username, :email, :password)
        ");

        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }

    // Mettre à jour l'avatar d'un utilisateur
    public function updateAvatar(int $userId, string $avatarPath): void
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET avatar = :avatar
            WHERE id = :id
        ");

        $stmt->execute([
            'avatar' => $avatarPath,
            'id' => $userId
        ]);
    }

}