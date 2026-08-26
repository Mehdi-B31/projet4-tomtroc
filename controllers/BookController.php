<?php

class BookController
{

    /**
     * Affiche la liste des livres disponibles, avec recherche optionnelle par titre.
     */
    public function showList() : void
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : null;

        $bookManager = new BookManager();
        $books = $bookManager->getAllAvailableBooks($search ?: null);

        $view = new View("Nos livres à l'échange");
        $view->render("books", [
            'books' => $books,
            'search' => $search
        ]);
    }


    /**
     * Affiche le détail d'un livre.
     */
    public function showDetail() : void
    {
        $bookId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        $bookManager = new BookManager();
        $book = $bookManager->getBookWithOwner($bookId);

        if (!$book) {
            echo "Ce livre n'existe pas.";
            return;
        }

        $view = new View($book['title']);
        $view->render("book_detail", [
            'book' => $book
        ]);
    }

    /**
     * Affiche le formulaire d'ajout d'un livre.
     */
    public function showAddForm() : void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $view = new View("Ajouter un livre");
        $view->render("book_form", [
            'book' => null,
            'formAction' => 'book_add_submit'
        ]);
    }

    /**
     * Traite l'ajout d'un livre, avec upload de photo optionnel.
     */
    public function create() : void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $title = $_POST['title'] ?? '';
        $author = $_POST['author'] ?? '';
        $description = $_POST['description'] ?? '';
        $available = isset($_POST['available']) && $_POST['available'] === '1' ? 1 : 0;

        if (empty($title) || empty($author) || empty($description)) {
            echo "Le titre, l'auteur et le commentaire sont obligatoires.";
            return;
        }

        $imageName = $this->handleImageUpload();

        $bookManager = new BookManager();
        $bookManager->addBook($userId, $title, $author, $description, $available, $imageName);

        header('Location: index.php?action=account');
        exit;
    }

    /**
     * Affiche le formulaire d'édition d'un livre existant, pré-rempli.
     */
    public function showEditForm() : void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $bookId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $userId = $_SESSION['user']['id'];

        $bookManager = new BookManager();
        $book = $bookManager->getBookByIdForUser($bookId, $userId);

        if (!$book) {
            echo "Ce livre n'existe pas ou ne vous appartient pas.";
            return;
        }

        $view = new View("Modifier un livre");
        $view->render("book_form", [
            'book' => $book,
            'formAction' => 'book_edit_submit'
        ]);
    }

    /**
     * Traite la modification d'un livre existant.
     */
    public function update() : void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $bookId = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $userId = $_SESSION['user']['id'];
        $title = $_POST['title'] ?? '';
        $author = $_POST['author'] ?? '';
        $description = $_POST['description'] ?? '';
        $available = isset($_POST['available']) && $_POST['available'] === '1' ? 1 : 0;

        if (empty($title) || empty($author) || empty($description)) {
            echo "Le titre, l'auteur et le commentaire sont obligatoires.";
            return;
        }

        $imageName = $this->handleImageUpload();

        $bookManager = new BookManager();
        $bookManager->updateBook($bookId, $userId, $title, $author, $description, $available, $imageName);

        header('Location: index.php?action=account');
        exit;
    }

    /**
     * Gère l'upload de la photo du livre : vérifie le type, génère un nom
     * de fichier unique, déplace le fichier vers assets/images/books/.
     * Retourne le nom du fichier stocké, ou null si aucune photo envoyée / erreur.
     */
    private function handleImageUpload() : ?string
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $_FILES['image']['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes, true)) {
            return null;
        }

        $extension = match ($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        };

        $fileName = uniqid('book_', true) . '.' . $extension;
        $destination = __DIR__ . '/../assets/images/books/' . $fileName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            return null;
        }

        return $fileName;
    }

    /**
     * Supprime un livre appartenant à l'utilisateur connecté, puis retourne sur "Mon compte".
     */
    public function delete() : void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $bookId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $userId = $_SESSION['user']['id'];

        if ($bookId > 0) {
            $bookManager = new BookManager();
            $bookManager->deleteBook($bookId, $userId);
        }

        header('Location: index.php?action=account');
        exit;
    }
}