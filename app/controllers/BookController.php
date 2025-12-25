<?php

require_once __DIR__ . '/../models/managers/BookManager.php';
require_once __DIR__ . '/../models/managers/MessageManager.php';

class BookController
{
    // Méthode privée pour compter les messages non lus
    private function unreadCount(): int
    {
        // Si utilisateur pas connecté, renvoie 0 messages non lus
        if (empty($_SESSION['user_id'])) {
            return 0;
        }

        // 2) On instancie le MessageManager
        $msgManager = new MessageManager();

        // 3) On récupère le compteur en base
        return (int) $msgManager->countUnreadMessages((int)$_SESSION['user_id']);
    }

    public function showBooks()
    {
        // Récupérer tous les livres
        $bookManager = new BookManager();
        $books = $bookManager->getAll();

        $unreadCount = $this->unreadCount();

        require_once __DIR__ . '/../views/books.php';
    }

    public function showBook(): void
    {
        // Récupérer et valider l'id dans l'URL (entier >= 1)
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if (!$id) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }

        // Charger le livre depuis la base via le manager
        $bookManager = new BookManager();
        $book = $bookManager->getById($id);

        // Si aucun livre trouvé pour cet id -> 404
        if (!$book) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }

        $unreadCount = $this->unreadCount();

        // 4) On renvoi la vue, qui affichera $book
        require __DIR__ . '/../views/book.php';
    }

    public function updateBook()
    {
        // Nouvel objet pour accéder aux méthodes liées aux livres
        $bookManager = new BookManager();

        // Récupère les valeurs envoyées par le formulaire en POST
        $id = $_POST['id'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        // Si une image a été envoyée ET que l’upload s’est bien passé
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Dossier où ranger l’image
            $uploadDir = '/tomtroc/public/assets/images/';
            // Nom de fichier d’origine (sans chemin)
            $fileName = basename($_FILES['image']['name']);
            // Dossier + nom complet
            $uploadFile = $uploadDir . $fileName;
            // On déplace le fichier temporaire vers le dossier final
            move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $uploadFile);
            // Chemin enregistré en base pour afficher l’image
            $image = $uploadFile;
        } else {
            // Pas de nouvelle image envoyée : on récupère le livre actuel et on garde l’ancienne image enregistrée en base
            $book = $bookManager->getById((int)$id);
            $image = $book['image'] ?? null;
        }

        // Met à jour le livre en base avec les nouvelles valeurs
        $bookManager->update(
            (int)$id,
            $title,
            $author,
            $description,
            $image ?? '',
            $status
        );

        header("Location: index.php?route=account");
        exit;
    }

    public function deleteBook(): void
    {

        // Récupérer et valider l'id dans l'URL (entier >= 1)
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if (!$id) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }

        // Récupérer le livre
        $bookManager = new BookManager();
        $book = $bookManager->getById($id);

        if (!$book) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }

        // Vérifier que l'utilisateur connecté est bien le propriétaire
        if (empty($_SESSION['user_id']) || (int)$book['user_id'] !== (int)$_SESSION['user_id']) {
            header('Location: index.php?route=account');
            exit;
        }

        // Supprimer puis rediriger
        $bookManager->deleteById($id);
        
        header('Location: index.php?route=account');
        exit;
    }
}
