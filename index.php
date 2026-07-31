<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'home';

try {
    switch ($action) {
        case 'home':
            $homeController = new HomeController();
            $homeController->showHome();
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

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}