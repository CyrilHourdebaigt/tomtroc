<?php
require_once __DIR__ . '/../models/Book.php';
session_start();

$bookModel = new Book();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Livre introuvable.";
    exit;
}

$bookId = (int) $_GET['id'];
$book = $bookModel->getById($_GET['id']);

if (!$book) {
    echo "Livre non trouvé.";
    exit;
}

include __DIR__ . '/header.php';
?>


<main class="book-page">
    <div class="back-books">
        <a href="index.php?route=books">Nos livres</a> &gt;
        <span><?= htmlspecialchars($book['title']) ?></span>
    </div>

    <div class="book-content">
         <div class="book-image">
                <img src="<?= htmlspecialchars($book['image']) ?>" alt="Couverture du livre">
        </div>

        <div class="book-details">
            <h1><?= htmlspecialchars($book['title']) ?></h1>
            <p class="author">par <?= htmlspecialchars($book['author']) ?></p>

            <h4 class="description-title">Description</h4>
            <p class="description"><?= nl2br(htmlspecialchars($book['description'])) ?></p>

            <div class="owner">
                <h4 class="description-title">PROPRIÉTAIRE</h4>
                <a href="index.php?route=publicAccount&id=<?= $book['user_id'] ?>">
                    <div class="owner-avatar">
                        <img src="<?= htmlspecialchars($book['avatar'] ?? '/tomtroc/public/assets/images/avatar-placeholder.jpg') ?>" alt="Photo de l'utilisateur">
                        <span><?= htmlspecialchars($book['username']) ?></span>
                    </div>
                </a>
            </div>

            <a class="contact-button" href="index.php?route=messages&id=<?= $book['user_id'] ?>">Envoyer un message</a>
        </div>
    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>