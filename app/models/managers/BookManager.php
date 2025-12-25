<?php

// Le Manager s'occupe UNIQUEMENT des requêtes SQL.

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../entities/BookEntity.php';

class BookManager
{
    // Connexion PDO réutilisable dans toutes les méthodes
    private PDO $db;

    // Constructeur : on récupère la connexion à la base via Database
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Récupère tous les livres
    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT books.*, users.username
            FROM books
            JOIN users ON books.user_id = users.id
            ORDER BY books.id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère un livre par son id
    public function getById(int $id): ?array
    {
        // Requête préparée car on a une valeur dynamique ($id)
        $stmt = $this->db->prepare("
            SELECT books.*, users.username, users.avatar
            FROM books
            JOIN users ON books.user_id = users.id
            WHERE books.id = :id
        ");

        $stmt->execute(['id' => $id]);

        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        return $book ?: null;
    }

    // Récupère tous les livres d'un utilisateur donné
    public function getByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT books.*, users.username
            FROM books
            JOIN users ON books.user_id = users.id
            WHERE books.user_id = :userId
            ORDER BY books.id DESC
        ");

        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Met à jour un livre (titre, auteur, description, image, statut)
    public function update(
        int $id,
        string $title,
        string $author,
        string $description,
        string $image,
        string $status
    ): bool {
        $stmt = $this->db->prepare("
            UPDATE books
            SET title = :title,
                author = :author,
                description = :description,
                image = :image,
                status = :status
            WHERE id = :id
        ");

        return $stmt->execute([
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'image' => $image,
            'status' => $status,
            'id' => $id
        ]);
    }

    //Supprime un livre par id
    public function deleteById(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM books
            WHERE id = :id
        ");

        return $stmt->execute(['id' => $id]);
    }
}