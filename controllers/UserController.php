<?php

class UserController
{

    /**
     * Affiche le formulaire d'inscription.
     */
    public function showRegister() : void
    {
        $view = new View("Inscription");
        $view->render("register");
    }

    /**
     * Traite l'inscription d'un utilisateur.
     */
    public function register() : void
    {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($email) || empty($password)) {
            echo "Tous les champs sont obligatoires.";
            return;
        }

        $userManager = new UserManager();
        $userManager->addUser($username, $email, $password);

        header('Location: index.php?action=login');
        exit;
    }

    /**
     * Affiche le formulaire de connexion.
     */
    public function showLogin() : void
    {
        $view = new View("Connexion");
        $view->render("login");
    }

    /**
     * Traite la connexion d'un utilisateur.
     */
    public function login() : void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo "Tous les champs sont obligatoires.";
            return;
        }

        $userManager = new UserManager();
        $user = $userManager->getUserByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            echo "Email ou mot de passe incorrect.";
            return;
        }

        $_SESSION['user'] = $user;
        header('Location: index.php?action=home');
        exit;
    }

    /**
     * Deconnecte l'utilisateur.
     */
    public function logout() : void
    {
        unset($_SESSION['user']);
        header('Location: index.php?action=home');
        exit;
    }

    /**
     * Affiche la page "Mon compte" : infos personnelles + bibliothèque.
     */
    public function showAccount() : void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        $userManager = new UserManager();
        $user = $userManager->getUserById($userId);

        $bookManager = new BookManager();
        $books = $bookManager->getBooksByUser($userId);

        $view = new View("Mon compte");
        $view->render("account", [
            'user' => $user,
            'books' => $books
        ]);
    }

    /**
     * Traite la mise à jour du profil (email, pseudo, mot de passe optionnel).
     */
    public function updateAccount() : void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($email)) {
            echo "Le pseudo et l'email sont obligatoires.";
            return;
        }

        $userManager = new UserManager();
        $userManager->updateProfile($userId, $username, $email, $password ?: null);

        // On rafraîchit la session avec les nouvelles infos
        $_SESSION['user'] = $userManager->getUserById($userId);

        header('Location: index.php?action=account');
        exit;
    }

    /**
     * Affiche le profil public d'un utilisateur (consultable par tous, sans modification).
     */
    public function showPublicProfile() : void
    {
        $userId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        $userManager = new UserManager();
        $user = $userManager->getUserById($userId);

        if (!$user) {
            echo "Cet utilisateur n'existe pas.";
            return;
        }

        $bookManager = new BookManager();
        $books = $bookManager->getBooksByUser($userId);
        // Seuls les livres disponibles sont montrés sur un profil public
        $books = array_filter($books, fn($book) => (int) $book['available'] === 1);

        $view = new View($user['username']);
        $view->render("profile_public", [
            'profileUser' => $user,
            'books' => $books
        ]);
    }
}