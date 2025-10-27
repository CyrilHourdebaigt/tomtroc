<?php
require_once __DIR__ . '/../models/Book.php';

$bookModel = new Book();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Livre introuvable.";
    exit;
}

$bookId = (int) $_GET['id'];
$book = $bookModel->getById($bookId);

if (!$book) {
    echo "Livre non trouvé.";
    exit;
}

if ($_SESSION['user_id'] != $book['user_id']) {
    header('Location: index.php?route=account');
    exit;
}

include __DIR__ . '/header.php';
?>


<main class="edit-book-page">
    <div class="top-edit">
        <a href="index.php?route=account" class="back-link">← retour</a>
        <h2>Modifier les informations</h2>
    </div>

    <div class="edit-book-container">
        <!-- Colonne gauche - image -->
        <div class="edit-book-left">
            <label for="image-upload" class="edit-photo-link">
                <img id="book-preview" src="<?= htmlspecialchars($book['image']) ?>" alt="Couverture du livre" class="edit-book-img" />
                <div class="edit-photo-text">Modifier la photo</div>
            </label>
        </div>

        <!-- Colonne droite - formulaire -->
        <form method="POST" action="index.php?route=updateBook" enctype="multipart/form-data" class="edit-book-form">
            <input type="hidden" name="id" value="<?= $book['id'] ?>">

            <input
                type="file"
                name="image"
                id="image-upload"
                accept="image/*"
                style="display: none;"
                onchange="previewBookImage(this)">

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>">
            </div>

            <div class="form-group">
                <label for="author">Auteur</label>
                <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>">
            </div>

            <div class="form-group">
                <label for="description">Commentaire</label>
                <textarea name="description"><?= htmlspecialchars($book['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="status">Disponibilité</label>
                <select name="status">
                    <option value="available" <?= $book['status'] === 'available' ? 'selected' : '' ?>>Disponible</option>
                    <option value="unavailable" <?= $book['status'] === 'unavailable' ? 'selected' : '' ?>>Indisponible</option>
                </select>
            </div>
            <button type="submit" class="btn-green">Valider</button>
        </form>
    </div>

    <script>
        function previewBookImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('book-preview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</main>

<?php include __DIR__ . '/footer.php'; ?>