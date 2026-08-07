<div class="books-header">
    <h1 class="page-title">Nos livres à l'échange</h1>

    <form action="index.php?action=books" method="get" class="search-form">
        <svg class="search-icon" width="16" height="16" viewBox="10 15 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M27 32L27.3536 31.6464V31.6464L27 32ZM24 29L23.6464 28.6464L23.2929 29L23.6464 29.3536L24 29ZM27.7071 32L27.3536 31.6464L27.3536 31.6464L27.7071 32ZM27.7071 31.2929L27.3536 31.6464V31.6464L27.7071 31.2929ZM24.7071 28.2929L25.0607 27.9393L24.7071 27.5858L24.3536 27.9393L24.7071 28.2929ZM25.5 24C25.5 27.5899 22.5899 30.5 19 30.5V31.5C23.1421 31.5 26.5 28.1421 26.5 24H25.5ZM19 17.5C22.5899 17.5 25.5 20.4101 25.5 24H26.5C26.5 19.8579 23.1421 16.5 19 16.5V17.5ZM12.5 24C12.5 20.4101 15.4101 17.5 19 17.5V16.5C14.8579 16.5 11.5 19.8579 11.5 24H12.5ZM19 30.5C15.4101 30.5 12.5 27.5899 12.5 24H11.5C11.5 28.1421 14.8579 31.5 19 31.5V30.5ZM27.3536 31.6464L24.3536 28.6464L23.6464 29.3536L26.6464 32.3536L27.3536 31.6464ZM27.3536 31.6464L27.3536 31.6464L26.6464 32.3536C27.037 32.7441 27.6701 32.7441 28.0607 32.3536L27.3536 31.6464ZM27.3536 31.6464L27.3536 31.6464L28.0607 32.3536C28.4512 31.963 28.4512 31.3299 28.0607 30.9393L27.3536 31.6464ZM24.3536 28.6464L27.3536 31.6464L28.0607 30.9393L25.0607 27.9393L24.3536 28.6464ZM24.3536 29.3536L25.0607 28.6464L24.3536 27.9393L23.6464 28.6464L24.3536 29.3536Z" fill="#A6A6A6"/>
        </svg>
        <input type="text" name="search" placeholder="Rechercher un livre" value="<?= htmlspecialchars($search ?? '') ?>">
    </form>
</div>

<div class="books-grid-page">
    <?php if (empty($books)) : ?>
    <p class="library-empty">Aucun livre ne correspond à votre recherche.</p>
    <?php endif; ?>

    <?php foreach ($books as $book) : ?>
    <?php $imageFile = $book['image'] ?? 'default-book.jpg'; ?>
    <a href="index.php?action=book&id=<?= $book['id'] ?>" class="book-card">
        <img src="/assets/images/books/<?= htmlspecialchars($imageFile) ?>"
             alt="<?= htmlspecialchars($book['title']) ?>"
             class="book-cover">
        <div class="book-card-body">
            <div class="book-card-title"><?= htmlspecialchars($book['title']) ?></div>
            <div class="book-card-author"><?= htmlspecialchars($book['author']) ?></div>
            <div class="book-card-seller">
                <div class="avatar-mini"><?= strtoupper(substr($book['username'] ?? 'U', 0, 1)) ?></div>
                <span>Vendu par : <?= htmlspecialchars($book['username'] ?? 'Inconnu') ?></span>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
</div>