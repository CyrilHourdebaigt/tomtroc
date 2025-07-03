<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Book.php';

class HomeController
{
    public function index()
    {

        $bookModel = new Book();
        $books = $bookModel->getAll();

        require_once __DIR__ . '/../views/home.php';
    }

    public function showBooks()
    {
        $bookModel = new Book();
        $books = $bookModel->getAll();

        require_once __DIR__ . '/../views/books.php';
    }

    public function showBook() {
        if (!isset($_GET['id'])) {
            echo "Aucun identifiant de livre fourni.";
            return;
        }
    
        $bookModel = new Book();
        $book = $bookModel->getById($_GET['id']);
    
        if (!$book) {
            echo "Livre non trouvé.";
            return;
        }
    
        require_once __DIR__ . '/../views/book.php';
    }
    
    public function showAccount()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $bookModel = new Book();
        $userBooks = $bookModel->getByUserId($userId);

        require_once __DIR__ . '/../views/account.php';
    }

    public function uploadAvatar()
    {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?route=login');
        exit;
    }

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileName = uniqid() . '_' . basename($_FILES['avatar']['name']);
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            // Mise à jour du champ 'avatar' dans la base de données
            require_once __DIR__ . '/../models/User.php';
            $userModel = new User();
            $userModel->updateAvatar($_SESSION['user_id'], $destination);

            $_SESSION['avatar'] = $destination;
        }
    }

    header('Location: index.php?route=account');
    exit;
    }

    public function publicAccount()
    {
        if (!isset($_GET['id'])) {
            header('Location: index.php');
            exit;
        }

        $userId = $_GET['id'];

        $userModel = new User();
        $bookModel = new Book();

        $user = $userModel->findById($userId);
        $books = $bookModel->getByUserId($userId);

        require_once __DIR__ . '/../views/publicAccount.php';
    }

    public function updateBook()
    {
        require_once __DIR__ . '/../models/Book.php';
        $bookModel = new Book();

        $id = $_POST['id'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '/tomtroc/public/assets/images/';
            $fileName = basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;
            move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $uploadFile);
            $image = $uploadFile;
        } else {
            $book = $bookModel->getById($id);
            $image = $book['image'];
        }

        $bookModel->update($id, $title, $author, $description, $image, $status);
        header("Location: index.php?route=account");
        exit;
    }

    public function messages() {
        $userId = $_SESSION['user_id'];
        $messageModel = new Message();
    
        $conversations = $messageModel->getConversations($userId);
        $selectedId = $_GET['contact'] ?? null;
        $messages = $selectedId ? $messageModel->getMessages($userId, $selectedId) : [];
    
        include __DIR__ . '/../views/messages.php';
    }
    
}
