<?php include __DIR__ . '/header.php'; ?>

<div class="account-page">

  <div class="account-header">
    <div class="account-card account-card-left">
      <div class="inside-card-left">
        <div class="avatar-wrapper">
            <img src="<?= isset($user['avatar']) ? $user['avatar'] : 'public/assets/images/avatar-placeholder.png' ?>" alt="Photo de profil" class="avatar-image">
        </div>
        <h2><?= htmlspecialchars($user['username']) ?></h2>
        <p>Membre depuis 1 an</p>
        <p class="biblio">BIBLIOTHÈQUE</p>
        <div class="book-count">
          <span class="icon">📚</span>
          <?= count($books) ?> livres
        </div>
        <button class="contact-button">Écrire un message</button>
      </div>
    </div>

    <div class="account-books">
      <table>
        <thead>
          <tr>
            <th>PHOTO</th>
            <th>TITRE</th>
            <th>AUTEUR</th>
            <th>DESCRIPTION</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($books as $book): ?>
            <tr>
              <td><img src="<?= htmlspecialchars($book['image']) ?>" alt="Livre" width="50" /></td>
              <td><?= htmlspecialchars($book['title']) ?></td>
              <td><?= htmlspecialchars($book['author']) ?></td>
              <td><?= htmlspecialchars(mb_strimwidth($book['description'], 0, 100, '...')) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="account-books-cards">
        <?php foreach ($books as $book): ?>
            <div class="book-card">
                <div class="img-title">
                    <img src="<?= htmlspecialchars($book['image']) ?>" alt="Photo du livre" class="book-card-img">
                    <div class="book-card-content">
                    <h4><?= htmlspecialchars($book['title']) ?></h4>
                    <p class="author"><?= htmlspecialchars($book['author']) ?></p>
                    </div>
                </div>
                <div class="actions">
                    <p class="description"><?= htmlspecialchars(mb_strimwidth($book['description'], 0, 150, '...')) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
  </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
