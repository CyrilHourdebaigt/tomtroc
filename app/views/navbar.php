<?php
require_once __DIR__ . '/../models/Message.php';

$messageModel = new Message();
$unreadCount = 0;

if (isset($_SESSION['user_id'])) {
    $unreadCount = $messageModel->countUnreadMessages($_SESSION['user_id']);
}
?>


<header class="header">
    <nav class="navbar">
        <div class="logo">
            <img src="/tomtroc/public/assets/images/logo-tomtroc.png" alt="Logo TomTroc">
        </div>
        <div class="burger-menu" id="burger-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <ul class="nav-links" id="nav-links">
            <div class="nav-left">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="index.php?route=books">Nos livres à l’échange</a></li>
            </div>
            <div class="nav-right">
                <li>
                    <a href="index.php?route=messages" style="<?= $unreadCount > 0 ? 'nav-link-bold' : '' ?>">
                        <img src="/tomtroc/public/assets/images/icons/Icon-messagerie.svg" 
                        alt="Messages" 
                        width="15"
                        class="icon-message">
                        Messagerie
                        <?php if ($unreadCount > 0): ?>
                        <span class="message-badge"><?= $unreadCount ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li>
                    <a href="index.php?route=account">
                        <img src="/tomtroc/public/assets/images/icons/Icon-compte.svg" alt="Compte" width="15" style="vertical-align: middle; margin-right: 5px;">
                        Mon compte
                    </a>
                </li>

                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="index.php?route=logout">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="index.php?route=login">Connexion</a></li>
                <?php endif; ?>
            </div>
        </ul>

    </nav>
</header>

<script>
        const burger = document.getElementById("burger-menu");
        const navLinks = document.querySelector(".nav-links");

        burger.addEventListener("click", () => {
            navLinks.classList.toggle("active");
        });
 </script>