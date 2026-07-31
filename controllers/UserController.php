<?php

class UserController {

    /**
     * Affiche le formulaire d'inscription.
     */
    public function showRegister() : void {
    $view = new View("Inscription");
    $view->render("register");
}
    /**
     * Traite l'inscription d'un utilisateur.
     */
    public function register() : void {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validation
        if (empty($username) || empty($email) || empty($password)) {
            echo "Tous les champs sont obligatoires.";
            return;
        }

        // Inscription
        $userManager = new UserManager();
        $userManager->addUser($username, $email, $password);

        // Redirection vers la page de connexion
        header('Location: index.php?action=login');
        exit;
    }

    /**
     * Affiche le formulaire de connexion.
     */
    public function showLogin() : void {
    $view = new View("Connexion");
    $view->render("login");
    }

    /**
     * Traite la connexion d'un utilisateur.
     */
    public function login() : void {
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
    public function logout() : void {
        unset($_SESSION['user']);
        header('Location: index.php?action=home');
        exit;
    }
}