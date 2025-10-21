<?php
require_once __DIR__ . '/Database.php';

class Message
{
    private $pdo;

    // Connexion à la base
    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    // Récupère tous les messages entre deux utilisateurs
    public function getConversation($userId1, $userId2)
    {
        $stmt = $this->pdo->prepare("
            SELECT messages.*, 
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

    // Récupère les conversations de l'utilisateur
    public function getUserConversations($userId)
    {
        $stmt = $this->pdo->prepare("
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

    // Compte les messages non lus reçus par un utilisateur
    public function countUnreadMessages($userId)
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM messages 
            WHERE receiver_id = :user_id AND is_read = 0
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchColumn();
    }

    // Changement de status des messages non lus
    public function markAsRead($userId, $senderId)
    {
        $stmt = $this->pdo->prepare("
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

    // Envoie un nouveau message
    public function sendMessage($senderId, $receiverId, $content)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO messages (sender_id, receiver_id, content, sent_at )
            VALUES (:sender_id, :receiver_id, :content, NOW())
        ");
        return $stmt->execute([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'content' => $content
        ]);
    }
}
