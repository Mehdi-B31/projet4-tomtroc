<?php
// Calcul de l'ancienneté du membre ("Membre depuis X")
$creationDate = new DateTime($user['date_creation']);
$now = new DateTime();
$diff = $creationDate->diff($now);

if ($diff->y >= 1) {
    $memberSince = $diff->y . ' an' . ($diff->y > 1 ? 's' : '');
} elseif ($diff->m >= 1) {
    $memberSince = $diff->m . ' mois';
} else {
    $memberSince = 'moins d\'un mois';
}

$avatarPath = $user['avatar'] ? '/assets/images/avatars/' . htmlspecialchars($user['avatar']) : '/assets/images/default-avatar.jpg';
?>

<h1 class="page-title">Mon compte</h1>

<div class="account-cards">
    <!-- CARD PROFIL -->
    <div class="account-card account-card-profile">
        <img src="<?= $avatarPath ?>" alt="Photo de profil" class="account-avatar">
        <a href="#" class="account-avatar-edit">modifier</a>

        <hr class="account-divider">

        <h2 class="account-username"><?= htmlspecialchars($user['username']) ?></h2>
        <p class="account-member-since">Membre depuis <?= $memberSince ?></p>

        <p class="account-library-label">BIBLIOTHEQUE</p>
        <p class="account-library-count"><?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?></p>

        <a href="index.php?action=book_add" class="btn btn-primary account-add-book-btn">Ajouter un livre</a>
    </div>

    <!-- CARD INFOS PERSONNELLES (lecture seule pour l'instant) -->
    <div class="account-card account-card-form">
        <h2 class="account-form-title">Vos informations personnelles</h2>

        <form action="index.php?action=account_update" method="post">
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="••••••••••">
            </div>

            <div class="form-group">
                <label for="username">Pseudo</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>

            <button type="submit" class="btn btn-ghost">Enregistrer</button>
        </form>
    </div>
</div>

<!-- TABLEAU BIBLIOTHEQUE (lecture seule) -->
<div class="library-table-wrapper">
    <table class="library-table">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Description</th>
                <th>Disponibilite</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($books)) : ?>
            <tr>
                <td colspan="6" class="library-empty">Vous n'avez pas encore ajouté de livre.</td>
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
                <td>
                    <?php if ($book['available']) : ?>
                        <span class="status-badge status-available">disponible</span>
                    <?php else : ?>
                        <span class="status-badge status-unavailable">non dispo.</span>
                    <?php endif; ?>
                </td>
                <td class="library-actions">
                    <a href="index.php?action=book_edit&id=<?= $book['id'] ?>" class="action-edit">Éditer</a>
                    <a href="index.php?action=book_delete&id=<?= $book['id'] ?>" class="action-delete">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>