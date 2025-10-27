<?php

require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/User.php';


class HomeController
{
    // Méthode privée pour compter les messages non lus
    private function unreadCount(): int
    {
        if (empty($_SESSION['user_id'])) {
            return 0;
        }

        $msgModel = new Message();
        return (int) $msgModel->countUnreadMessages((int)$_SESSION['user_id']);
    }

    public function index()
    {
        // On récupère les livres
        $bookModel = new Book();
        $books = $bookModel->getAll();

        $unreadCount = $this->unreadCount();

        require_once __DIR__ . '/../views/home.php';
    }

    public function showAccount()
    {
        // Si pas connecté, redirection vers la page de login
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        // On récupère les livres appartenant à cet utilisateur
        $bookModel = new Book();
        $userBooks = $bookModel->getByUserId($userId);

        $unreadCount = $this->unreadCount();

        require_once __DIR__ . '/../views/account.php';
    }

    public function uploadAvatar()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        // Si un fichier "avatar" a bien été envoyé et sans erreur d’upload
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {

            // Dossier de destination des avatars
            $uploadDir = 'public/uploads/';

            // On le crée si il n'existe pas
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Chemin temporaire du fichier reçu par PHP
            $fileTmpPath = $_FILES['avatar']['tmp_name'];

            // Fabrique un nom de fichier unique + garde le nom d’origine
            $fileName = uniqid() . '_' . basename($_FILES['avatar']['name']);

            // Chemin final
            $destination = $uploadDir . $fileName;

            // On déplace le fichier du temporaire vers le dossier final
            if (move_uploaded_file($fileTmpPath, $destination)) {

                // Mise à jour du champ 'avatar' dans la base de données
                $userModel = new User();
                $userModel->updateAvatar($_SESSION['user_id'], $destination);

                // On met aussi le chemin en session pour l’affichage immédiat
                $_SESSION['avatar'] = $destination;
            }
        }

        header('Location: index.php?route=account');
        exit;
    }

    public function publicAccount()
    {
        // Si aucun id passé en GET, retour à l’accueil
        if (!isset($_GET['id'])) {
            header('Location: index.php');
            exit;
        }

        // Id du profil public à afficher
        $userId = $_GET['id'];

        // On charge les infos du user + ses livres
        $userModel = new User();
        $bookModel = new Book();

        $user = $userModel->findById($userId);
        $books = $bookModel->getByUserId($userId);

        $unreadCount = $this->unreadCount();

        require_once __DIR__ . '/../views/publicAccount.php';
    }
}
