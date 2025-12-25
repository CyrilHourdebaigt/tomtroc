<?php

// Le Manager s'occupe UNIQUEMENT des requêtes SQL.

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../entities/MessageEntity.php';

class MessageManager
{
    // Connexion PDO réutilisable dans toutes les méthodes
    private PDO $db;

    // Constructeur : on récupère la connexion à la base via Database
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Récupère tous les messages entre deux utilisateurs
    public function getConversation(int $userId1, int $userId2): array
    {
        // Requête préparée avec placeholders nommés :user1 et :user2
        $stmt = $this->db->prepare("
            SELECT
                messages.*,
                sender.username AS sender_name,
                receiver.username AS receiver_name,
                sender.avatar AS sender_avatar,
                receiver.avatar AS receiver_avatar
            FROM messages
            JOIN users AS sender ON messages.sender_id = sender.id
            JOIN users AS receiver ON messages.receiver_id = receiver.id
            WHERE (sender_id = :user1 AND receiver_id = :user2)
               OR (sender_id = :user2 AND receiver_id = :user1)
            ORDER BY sent_at ASC
        ");

        $stmt->execute([
            'user1' => $userId1,
            'user2' => $userId2
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère la liste des conversations de l'utilisateur
    public function getUserConversations(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT
                u.id,
                u.username,
                u.avatar,
                m.content AS last_message,
                MAX(sent_at) AS last_date
            FROM messages m
            JOIN users u ON (u.id = m.sender_id OR u.id = m.receiver_id)
            WHERE (m.sender_id = :userId OR m.receiver_id = :userId)
              AND u.id != :userId
            GROUP BY u.id
            ORDER BY last_date DESC
        ");

        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Compte le nombre de messages non lus reçus par un utilisateur
    public function countUnreadMessages(int $userId): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM messages
            WHERE receiver_id = :user_id
              AND is_read = 0
        ");

        $stmt->execute(['user_id' => $userId]);

        return (int) $stmt->fetchColumn();
    }

    // Marque comme lus les messages
    public function markAsRead(int $userId, int $senderId): void
    {
        $stmt = $this->db->prepare("
            UPDATE messages
            SET is_read = 1
            WHERE receiver_id = :userId
              AND sender_id = :senderId
              AND is_read = 0
        ");

        $stmt->execute([
            'userId' => $userId,
            'senderId' => $senderId
        ]);
    }

    // Envoie un nouveau message :
    public function sendMessage(int $senderId, int $receiverId, string $content): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO messages (sender_id, receiver_id, content, sent_at)
            VALUES (:sender_id, :receiver_id, :content, NOW())
        ");

        return $stmt->execute([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'content' => $content
        ]);
    }
}