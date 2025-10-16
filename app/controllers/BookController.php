<?php

require_once __DIR__ . '/../models/Book.php';

class BookController
{

    public function showBooks()
    {
        $bookModel = new Book();
        $books = $bookModel->getAll();

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

        // Charger le livre depuis la base via le modèle
        $bookModel = new Book();
        $book = $bookModel->getById($id);

        // Si aucun livre trouvé pour cet id -> 404
        if (!$book) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }
        // 4) On renvoi la vue, qui affichera $book

        require __DIR__ . '/../views/book.php';
    }

    public function updateBook()
    {
        // Nouvel objet pour accéder aux méthodes liées aux livres
        $bookModel = new Book();

        // Récupère les valeurs envoyées par le formulaire en POST
        $id = $_POST['id'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        // Si une image a été envoyée ET que l’upload s’est bien passé
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
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
            $book = $bookModel->getById($id);
            $image = $book['image'];
        }

        // Met à jour le livre en base avec les nouvelles valeurs
        $bookModel->update($id, $title, $author, $description, $image, $status);
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
        $bookModel = new Book();
        $book = $bookModel->getById($id);
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
        $bookModel->deleteById($id);
        header('Location: index.php?route=account');
        exit;
    }
}
