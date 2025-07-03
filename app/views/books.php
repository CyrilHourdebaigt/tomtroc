<?php session_start(); ?>
<?php include __DIR__ . '/header.php'; ?>

  <main class="books-page">
    <div class="container livres-header">
        <h1>Nos livres à l’échange</h1>
        <div class="search-container">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242.656a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/>
            </svg>
            <input type="text" id="searchInput" class="search-input" placeholder="Rechercher un livre">
        </div>
    </div>

    <div class="container-livres-grid">
    <?php foreach ($books as $book) : ?>
        <div class="livre-card">
            <a href="index.php?route=book&id=<?= $book['id'] ?>">
                <div class="livre-img-wrapper">
                    <img src="<?= htmlspecialchars($book['image']) ?>" alt="Couverture du livre">
                </div>
                <div class="livre-info">
                    <p><strong><?= htmlspecialchars($book['title']) ?></strong></p>
                    <p class="card-author"><?= htmlspecialchars($book['author']) ?></p>
                </div>
            </a>
            <p class="vendeur">
                Vendu par :
                <a href="index.php?route=publicAccount&id=<?= $book['user_id'] ?>">
                    <?= htmlspecialchars($book['username']) ?>
                </a>
            </p>
        </div>

    <?php endforeach; ?>
    </div>

  </main>

  <?php include __DIR__ . '/footer.php'; ?>

    <script>
        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('.livre-card');

        searchInput.addEventListener('input', () => {
            const searchValue = searchInput.value.toLowerCase();

            cards.forEach(card => {
            const title = card.querySelector('strong').textContent.toLowerCase();
            const author = card.querySelector('p:nth-of-type(2)').textContent.toLowerCase();

            const isVisible = title.includes(searchValue) || author.includes(searchValue);
            card.style.display = isVisible ? 'block' : 'none';
            });
        });
    </script> 