<?php

require_once 'Database.php';

class Book
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("
            SELECT books.*, users.username 
            FROM books
            JOIN users ON books.user_id = users.id
            ORDER BY books.id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT books.*, users.username, users.avatar
            FROM books 
            JOIN users ON books.user_id = users.id 
            WHERE books.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUserId($userId)
    {
        $stmt = $this->pdo->prepare("
            SELECT books.*, users.username 
            FROM books 
            JOIN users ON books.user_id = users.id 
            WHERE books.user_id = ?
            ORDER BY books.id DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $author, $description, $image, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE books SET title = ?, author = ?, description = ?, image = ?, status = ? WHERE id = ?");
        return $stmt->execute([$title, $author, $description, $image, $status, $id]);
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM books WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }


}