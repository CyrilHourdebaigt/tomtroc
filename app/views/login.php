<?php include __DIR__ . '/header.php'; ?>

  <div class="auth-page">
    <div class="auth-content">
      
      <div class="auth-left">
        <h2>Connexion</h2>
        <form method="POST" action="index.php?route=doLogin">
          <label for="email">Adresse email</label>
          <input type="email" name="email" id="email" placeholder="Adresse email" required>

          <label for="password">Mot de passe</label>
          <input type="password" name="password" id="password" placeholder="Mot de passe" required>

          <button type="submit">Se connecter</button>
        </form>

        <p class="login-link">Pas de compte ? <a href="index.php?route=register">Inscrivez-vous</a></p>
      </div>

      <div class="auth-right">
        <img src="assets/images/bookshelf.png" alt="Image bibliothèque">
      </div>

    </div>
  </div>

<?php include __DIR__ . '/footer.php'; ?>