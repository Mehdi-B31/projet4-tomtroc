<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

// On empêche PHP d'afficher directement les erreurs techniques (warnings, notices, deprecated...)
// Le try/catch plus bas ne suffit pas à lui seul : il ne capture que les exceptions/erreurs
// explicitement levées, pas les messages que PHP affiche spontanément.
ini_set('display_errors', '0');
error_reporting(E_ALL);

$action = isset($_GET['action']) ? $_GET['action'] : 'home';

try {
    switch ($action) {
        case 'home':
            $homeController = new HomeController();
            $homeController->showHome();
            break;

        case 'books':
            $bookController = new BookController();
            $bookController->showList();
            break;

        case 'book':
            $bookController = new BookController();
            $bookController->showDetail();
            break;

        case 'register':
            $userController = new UserController();
            $userController->showRegister();
            break;

        case 'register_submit':
            $userController = new UserController();
            $userController->register();
            break;

        case 'login':
            $userController = new UserController();
            $userController->showLogin();
            break;

        case 'login_submit':
            $userController = new UserController();
            $userController->login();
            break;

        case 'logout':
            $userController = new UserController();
            $userController->logout();
            break;

        case 'account':
            $userController = new UserController();
            $userController->showAccount();
            break;

        case 'account_update':
            $userController = new UserController();
            $userController->updateAccount();
            break;

        case 'profile':
            $userController = new UserController();
            $userController->showPublicProfile();
            break;

        case 'messaging':
            $messageController = new MessageController();
            $messageController->showMessaging();
            break;

        case 'message_new':
            $messageController = new MessageController();
            $messageController->startConversation();
            break;

        case 'message_send':
            $messageController = new MessageController();
            $messageController->send();
            break;

        case 'book_delete':
            $bookController = new BookController();
            $bookController->delete();
            break;

        case 'book_add':
            $bookController = new BookController();
            $bookController->showAddForm();
            break;

        case 'book_add_submit':
            $bookController = new BookController();
            $bookController->create();
            break;

        case 'book_edit':
            $bookController = new BookController();
            $bookController->showEditForm();
            break;

        case 'book_edit_submit':
            $bookController = new BookController();
            $bookController->update();
            break;

        default:
            http_response_code(404);
            $view = new View("Page introuvable");
            $view->render("404");
            exit;
    }
} catch (Throwable $e) {
    // Throwable (et non Exception) pour couvrir aussi les erreurs fatales PHP
    // (TypeError, erreur de type d'argument, division par zéro, etc.), pas seulement
    // les exceptions qu'on lève nous-mêmes volontairement.
    // On n'affiche jamais le message technique à l'utilisateur : ça pourrait révéler
    // des détails internes (structure de la BDD, chemins serveur, etc.)
    http_response_code(500);
    echo "Une erreur est survenue. Merci de réessayer plus tard.";
}