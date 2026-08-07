<?php
$isEdit = $book !== null;
$currentImage = $isEdit && $book['image'] ? '/assets/images/books/' . htmlspecialchars($book['image']) : '/assets/images/default-book.jpg';
?>

<a href="index.php?action=account" class="back-link">← retour</a>

<h1 class="page-title"><?= $isEdit ? 'Modifier les informations' : 'Ajouter un livre' ?></h1>

<div class="book-form-card">
    <form action="index.php?action=<?= $formAction ?>" method="post" enctype="multipart/form-data" class="book-form">
        <?php if ($isEdit) : ?>
        <input type="hidden" name="id" value="<?= $book['id'] ?>">
        <?php endif; ?>

        <div class="book-form-photo">
            <label>Photo</label>
            <img src="<?= $currentImage ?>" alt="Aperçu du livre" class="book-form-photo-preview" id="photo-preview">
            <label for="image" class="book-form-photo-label"><?= $isEdit ? 'Modifier la photo' : 'Ajouter une photo' ?></label>
            <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/webp" class="book-form-photo-input">
        </div>

        <div class="book-form-fields">
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" value="<?= $isEdit ? htmlspecialchars($book['title']) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="author">Auteur</label>
                <input type="text" name="author" id="author" value="<?= $isEdit ? htmlspecialchars($book['author']) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Commentaire</label>
                <textarea name="description" id="description" rows="8" required><?= $isEdit ? htmlspecialchars($book['description']) : '' ?></textarea>
            </div>

            <div class="form-group">
                <label for="available">Disponibilite</label>
                <select name="available" id="available">
                    <option value="1" <?= ($isEdit && $book['available']) ? 'selected' : '' ?>>disponible</option>
                    <option value="0" <?= ($isEdit && !$book['available']) ? 'selected' : '' ?>>non disponible</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
</div>