<?php
$imageFile = $book['image'] ?? 'default-book.jpg';
$ownerAvatar = $book['owner_avatar'] ? '/assets/images/avatars/' . htmlspecialchars($book['owner_avatar']) : null;
?>

<nav class="breadcrumb">
    <a href="index.php?action=books">Nos livres</a> &gt; <?= htmlspecialchars($book['title']) ?>
</nav>

<div class="book-detail-page">
    <div class="book-detail-image">
        <img src="/assets/images/books/<?= htmlspecialchars($imageFile) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
    </div>

    <div class="book-detail-content">
        <h1 class="book-detail-title"><?= htmlspecialchars($book['title']) ?></h1>
        <p class="book-detail-author">par <?= htmlspecialchars($book['author']) ?></p>

        <hr class="book-detail-divider">

        <p class="book-detail-label">Description</p>
        <div class="book-detail-description">
            <?php foreach (explode("\n", $book['description']) as $paragraph) : ?>
                <?php if (trim($paragraph) !== '') : ?>
                <p><?= htmlspecialchars($paragraph) ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <p class="book-detail-label">Proprietaire</p>
        <a href="index.php?action=profile&id=<?= $book['owner_id'] ?>" class="book-detail-owner">
            <?php if ($ownerAvatar) : ?>
                <img src="<?= $ownerAvatar ?>" alt="<?= htmlspecialchars($book['owner_username']) ?>" class="avatar-medium">
            <?php else : ?>
                <div class="avatar-medium avatar-medium-fallback"><?= strtoupper(substr($book['owner_username'] ?? 'U', 0, 1)) ?></div>
            <?php endif; ?>
            <span><?= htmlspecialchars($book['owner_username'] ?? 'Utilisateur inconnu') ?></span>
        </a>

        <a href="index.php?action=message_new&id=<?= $book['owner_id'] ?>" class="btn btn-primary book-detail-message-btn">Envoyer un message</a>
    </div>
</div>