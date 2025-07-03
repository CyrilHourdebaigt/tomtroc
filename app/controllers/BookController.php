<?php

require_once __DIR__ . '/../models/Book.php';

class BookController
{
    public function deleteBook()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "ID invalide.";
            exit;
        }

        $bookId = (int) $_GET['id'];

        $bookModel = new Book();
        $bookModel->deleteById($bookId);

        header("Location: index.php?route=account");
        exit;
    }
}
