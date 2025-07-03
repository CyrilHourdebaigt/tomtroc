<?php session_start(); ?>
<?php include __DIR__ . '/header.php'; ?>

    <section class="hero">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>Rejoignez nos lecteurs passionnés</h1>
                <p>
                    Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture.
                    Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.
                </p>
                <a href="#" class="btn">Découvrir</a>
            </div>
            <div class="hero-image">
                <img src="/tomtroc/public/assets/images/Home.png" alt="Librairie">
            </div>
        </div>
    </section>

    <section id="livres" class="livres">
        <div class="container">
            <h2>Les derniers livres ajoutés</h2>
            <div class="livres-grid">
            <?php foreach (array_slice($books, 0, 4) as $book): ?>
                <div class="livre-card">
                <div class="livre-img-wrapper">
                    <img src="<?= htmlspecialchars($book['image']) ?>" alt="Couverture du livre">
                </div>
                <div class="livre-info">
                    <p><strong><?= htmlspecialchars($book['title']) ?></strong></p>
                    <p class="auteur"><?= htmlspecialchars($book['author']) ?></p>
                    <p class="vendeur">Vendu par : <?= htmlspecialchars($book['username']) ?></p>
                </div>
                </div>
            <?php endforeach; ?>
            </div>

            <a href="index.php?route=books" class="btn btn-livres">Voir tous les livres</a>
        </div>
    </section>

    <section class="fonctionnement">
        <div class="container">
            <h2>Comment ça marche ?</h2>
            <p>Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>
            <div class="steps">
                <div class="step">Inscrivez-vous gratuitement sur notre plateforme</div>
                <div class="step">Ajoutez les livres que vous souhaitez échanger à votre profil.</div>
                <div class="step">Parcourez les livres disponibles chez d'autres membres.</div>
                <div class="step">Proposez un échange et discutez avec d'autres passionnés de lecture.</div>
            </div>
            <a href="#" class="btn">Voir tous les livres</a>
        </div>
    </section>

    <section class="valeurs">
        <picture class="BanHome">
            <source media="(max-width: 768px)" srcset="/tomtroc/public/assets/images/BanHome-mobile.png">
            <img class="BanHome-img" src="/tomtroc/public/assets/images/BanHome.png" alt="Bibliothèques">
        </picture>

        <div class="valeurs-content container">  
                <div class="valeurs-texte">
                    <h2>Nos valeurs</h2>
                    <p>
                        Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté.
                        Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs.
                        Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.<br><br>
                        Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.<br><br>
                        Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.
                    </p>

                    <div class="valeurs-icon">
                        <span class="signature">L’équipe Tom Troc</span>
                        <img src="/tomtroc/public/assets/images/coeur.svg" alt="Icône coeur">
                    </div>
                </div> 
        </div>
    </section>

<?php include __DIR__ . '/footer.php'; ?>