<?php
$creationDate = new DateTime($profileUser['date_creation']);
$now = new DateTime();
$diff = $creationDate->diff($now);

if ($diff->y >= 1) {
    $memberSince = $diff->y . ' an' . ($diff->y > 1 ? 's' : '');
} elseif ($diff->m >= 1) {
    $memberSince = $diff->m . ' mois';
} else {
    $memberSince = 'moins d\'un mois';
}

$avatarPath = $profileUser['avatar'] ? '/assets/images/avatars/' . htmlspecialchars($profileUser['avatar']) : '/assets/images/default-avatar.jpg';
?>

<div class="account-cards">
    <!-- CARD PROFIL -->
    <div class="account-card account-card-profile">
        <img src="<?= $avatarPath ?>" alt="Photo de profil" class="account-avatar">

        <hr class="account-divider">

        <h2 class="account-username"><?= htmlspecialchars($profileUser['username']) ?></h2>
        <p class="account-member-since">Membre depuis <?= $memberSince ?></p>

        <p class="account-library-label">BIBLIOTHEQUE</p>
        <p class="account-library-count"><?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?></p>

        <a href="index.php?action=message_new&id=<?= $profileUser['id'] ?>" class="btn btn-ghost account-add-book-btn">Écrire un message</a>
    </div>

    <!-- TABLEAU BIBLIOTHEQUE (public, lecture seule, sans statut ni actions) -->
    <div class="library-table-wrapper profile-public-table-wrapper">
        <table class="library-table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($books)) : ?>
                <tr>
                    <td colspan="4" class="library-empty">Aucun livre disponible pour l'instant.</td>
                </tr>
                <?php endif; ?>
                <?php foreach ($books as $book) : ?>
                <?php $imageFile = $book['image'] ?? 'default-book.jpg'; ?>
                <tr>
                    <td>
                        <img src="/assets/images/books/<?= htmlspecialchars($imageFile) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="library-book-thumb">
                    </td>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td class="library-description"><?= htmlspecialchars(mb_strimwidth($book['description'], 0, 80, '...')) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>