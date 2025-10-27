<?php
include __DIR__ . '/header.php';
?>

<div class="account-page">
  <h2 class="title-page">Mon compte</h2>
  <div class="account-header">

    <div class="account-card account-card-left">
      <div class="inside-card-left">
        <div class="avatar">
          <form action="index.php?route=uploadAvatar" method="POST" enctype="multipart/form-data">
            <div class="avatar-wrapper">
              <img src="<?= isset($_SESSION['avatar']) ? $_SESSION['avatar'] : 'public/assets/images/avatar-placeholder.png' ?>"
                alt="Avatar utilisateur" class="avatar-image">

              <a href="#"
                class="edit-avatar"
                onclick="document.getElementById('avatar-upload').click(); return false;"
                aria-label="Modifier l’avatar">
                modifier
              </a>

              <label for="avatar-upload" class="sr-only">Télécharger un avatar</label>
              <input type="file"
                name="avatar"
                id="avatar-upload"
                style="display: none;"
                accept="image/*"
                onchange="this.form.submit()">
            </div>
          </form>
        </div>
        <h2><?= htmlspecialchars($_SESSION['username']) ?></h2>
        <p>Membre depuis 1 an</p>
        <p class="biblio">BIBLIOTHEQUE
        <p>
        <div class="book-count">
          <span class="icon">📚</span>
          <?= count($userBooks) ?> livres
        </div>
      </div>
    </div>

    <div class="account-card account-card-right">
      <div class="inside-card-right">
        <h3>Vos informations personnelles</h3>
        <form action="#" method="post">
          <label for="email">Adresse email</label>
          <input type="email" id="email"
            value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '' ?>"
            class="input-disabled" disabled>

          <label for="password">Mot de passe</label>
          <input type="password" id="password" class="input-disabled" value="********" disabled>

          <label for="pseudo">Pseudo</label>
          <input type="text" id="pseudo"
            name="pseudo"
            value="<?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '' ?>">

          <button type="submit">Enregistrer</button>
        </form>
      </div>
    </div>
  </div>

  <div class="account-books">
    <table>
      <thead>
        <tr>
          <th>Photo</th>
          <th>Titre</th>
          <th>Auteur</th>
          <th>Description</th>
          <th>Disponibilité</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($userBooks as $book): ?>
          <tr>
            <td><img src="<?= htmlspecialchars($book['image']) ?>" alt="Photo livre" width="60"></td>
            <td><?= htmlspecialchars($book['title']) ?></td>
            <td><?= htmlspecialchars($book['author']) ?></td>
            <td><?= htmlspecialchars(mb_strimwidth($book['description'], 0, 100, '...')) ?></td>
            <td>
              <?php if ($book['status'] === 'available') : ?>
                <span class="badge badge-success">Disponible</span>
              <?php else : ?>
                <span class="badge badge-danger">Indisponible</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="index.php?route=editBook&id=<?= $book['id'] ?>" class="link-edit">Éditer</a>
              <a href="index.php?route=deleteBook&id=<?= $book['id'] ?>" class="link-delete" onclick="return confirm('Es-tu sûr de vouloir supprimer ce livre ?')">Supprimer</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="account-books-cards">
    <?php foreach ($userBooks as $book): ?>
      <div class="book-card">
        <div class="img-title">
          <img src="<?= htmlspecialchars($book['image']) ?>" alt="Photo livre" class="book-card-img">
          <div class="book-card-content">
            <h4><?= htmlspecialchars($book['title']) ?></h4>
            <p class="author"><?= htmlspecialchars($book['author']) ?></p>
            <span class="badge <?= $book['status'] === 'available' ? 'badge-success' : 'badge-danger' ?>">
              <?= $book['status'] === 'available' ? 'Disponible' : 'Indisponible' ?>
            </span>
          </div>
        </div>
        <div class="actions">
          <p class="description"><?= htmlspecialchars(mb_strimwidth($book['description'], 0, 150, '...')) ?></p>
          <a href="index.php?route=editBook&id=<?= $book['id'] ?>" class="link-edit">Éditer</a>
          <a href="index.php?route=deleteBook&id=<?= $book['id'] ?>" class="link-delete" onclick="return confirm('Es-tu sûr de vouloir supprimer ce livre ?')">Supprimer</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>