<?php

require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/User.php';

class MessageController
{
    private $messageModel;
    private $userModel;

    public function __construct()
    {
        $this->messageModel = new Message();
        $this->userModel = new User();
    }

    // Compteur de messages non-lus
    private function unreadCount(): int
    {
        if (empty($_SESSION['user_id'])) return 0;
        return (int) $this->messageModel->countUnreadMessages((int)$_SESSION['user_id']);
    }

    // Affiche la page de messagerie entre 2 utilisateurs
    public function showMessages($receiverId)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $currentUserId = $_SESSION['user_id'];

        // Récupère les messages entre les deux utilisateurs
        $messages = $this->messageModel->getConversation($currentUserId, $receiverId);

        // Récupère l'utilisateur sélectionné (celui avec qui on discute)
        $selectedUser = $this->userModel->findById($receiverId);
        $selectedUserId = $receiverId;

        // Mettre à jour les messages comme lus
        $this->messageModel->markAsRead($currentUserId, $receiverId);

        // Récupère toutes les conversations du user connecté
        $conversations = $this->messageModel->getUserConversations($currentUserId);

        $unreadCount = $this->unreadCount();

        require_once __DIR__ . '/../views/messages.php';
    }


    // Gère l’envoi d’un message
    public function sendMessage()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        // On vérifie que la requête provient bien d’un formulaire envoyé en POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $senderId = $_SESSION['user_id'];
            $receiverId = $_POST['receiver_id'];
            // contenu du message (nettoyé des espaces)
            $content = trim($_POST['content']);

            // Si le message n'est pas vide, on l'enregistre via le modèle
            if (!empty($content)) {
                $this->messageModel->sendMessage($senderId, $receiverId, $content);
            }

            header("Location: index.php?route=messages&id=$receiverId");
            exit;
        }
    }
}
