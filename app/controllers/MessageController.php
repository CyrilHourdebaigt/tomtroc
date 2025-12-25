<?php

require_once __DIR__ . '/../models/managers/MessageManager.php';
require_once __DIR__ . '/../models/managers/UserManager.php';

class MessageController
{
    private MessageManager $messageManager;
    private UserManager $userManager;

    public function __construct()
    {
        $this->messageManager = new MessageManager();
        $this->userManager = new UserManager();
    }

    // Compteur de messages non-lus
    private function unreadCount(): int
    {
        if (empty($_SESSION['user_id'])) return 0;
        return (int) $this->messageManager->countUnreadMessages((int)$_SESSION['user_id']);
    }

    // Affiche la page de messagerie entre 2 utilisateurs
    public function showMessages($receiverId)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $currentUserId = (int) $_SESSION['user_id'];

        // On charge la liste des conversations (colonne de gauche)
        $conversations = $this->messageManager->getUserConversations($currentUserId);

        // Valeurs par défaut si aucune conversation sélectionnée
        $messages = [];
        $selectedUser = null;
        $selectedUserId = null;

        // Si un receiverId est présent, on charge la conversation
        $receiverId = filter_var($receiverId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

        if ($receiverId) {
            $selectedUserId = (int) $receiverId;

            // Récupère les messages entre les deux utilisateurs
            $messages = $this->messageManager->getConversation($currentUserId, $selectedUserId);

            // Récupère l'utilisateur sélectionné (celui avec qui on discute)
            $selectedUser = $this->userManager->findById($selectedUserId);

            // Mettre à jour les messages comme lus
            $this->messageManager->markAsRead($currentUserId, $selectedUserId);
        }

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

        // On vérifie que la requête provient bien d’un formulaire POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $senderId = (int) $_SESSION['user_id'];

            // Validation du receiver_id
            $receiverId = filter_input(
                INPUT_POST,
                'receiver_id',
                FILTER_VALIDATE_INT,
                ['options' => ['min_range' => 1]]
            );

            // Si l'id du destinataire est invalide → retour à la messagerie
            if (!$receiverId) {
                header('Location: index.php?route=messages');
                exit;
            }

            // Contenu du message nettoyé
            $content = trim($_POST['content'] ?? '');

            // Si le message n'est pas vide, on l'enregistre
            if ($content !== '') {
                $this->messageManager->sendMessage($senderId, $receiverId, $content);
            }

            header("Location: index.php?route=messages&id=$receiverId");
            exit;
        }
    }
}
