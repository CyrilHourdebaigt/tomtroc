<?php 
include __DIR__ . '/header.php'; 
?>

<main class="messagerie-page">
    <div class="messagerie-container">
        <!-- Liste des conversations -->
        <aside class="conversation-list <?= isset($selectedUserId) ? 'hide-on-mobile' : '' ?>">
            <h2>Messagerie</h2>
            <ul>
                <?php foreach ($conversations as $conv) : ?>
                    <li class="<?= $conv['id'] === $selectedUserId ? 'active' : '' ?>">
                        <a href="index.php?route=messages&id=<?= $conv['id'] ?>" class="conversation-link">
                            <img src="<?= htmlspecialchars($conv['avatar']) ?>" alt="avatar" class="avatar-small">
                            <div>
                                <strong><?= htmlspecialchars($conv['username']) ?></strong><br>
                                <span><?= htmlspecialchars($conv['last_message']) ?></span>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <!-- Zone des messages -->
        <section class="message-content <?= isset($selectedUserId) ? 'show-on-mobile' : 'hide-on-mobile' ?>">
            <div class="back-button">
                <a href="index.php?route=messages">
                    ← retour
                </a>
            </div>
            <?php if ($selectedUserId && $selectedUser) : ?>
                <div class="message-header">
                    <img src="<?= htmlspecialchars($selectedUser['avatar']) ?>" alt="avatar" class="avatar-small">
                    <strong><?= htmlspecialchars($selectedUser['username']) ?></strong>
                </div>

                <div class="message-thread" id="message-thread">
                    <?php foreach ($messages as $message) : ?>
                        <?php $isSent = intval($message['sender_id']) === intval($_SESSION['user_id']); ?>
                        <div class="message-row <?= $isSent ? 'sent' : 'received' ?>">

                            <!-- Avatar + heure -->
                            <div class="message-meta">
                                <?php if (!$isSent): ?>
                                    <img src="<?= htmlspecialchars($selectedUser['avatar']) ?>" alt="avatar" class="avatar-small-s">
                                <?php endif; ?>
                                <span class="message-time"><?= date('d/m H:i', strtotime($message['sent_at'])) ?></span>
                            </div>

                            <!-- Message -->
                            <div class="message-bubble">
                                <p><?= nl2br(htmlspecialchars($message['content'])) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>


                <!-- Formulaire d'envoi -->
                <form class="message-form" method="POST" action="index.php?route=sendMessage">
                    <input type="hidden" name="receiver_id" value="<?= $selectedUserId ?>">
                    <label for="content" class="sr-only">Votre message</label>
                    <input type="text" name="content" id="content" placeholder="Tapez votre message ici" required>
                    <button type="submit">Envoyer</button>
                </form>
            <?php else : ?>
                <p class="no-selection">Sélectionnez une conversation à gauche.</p>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>

<script>
    window.onload = function() {
        const thread = document.getElementById("message-thread");
        if (thread) {
            thread.scrollTop = thread.scrollHeight;
        }
    };
</script>