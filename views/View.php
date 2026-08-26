<?php

class View
{
    private $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function render(string $template, array $data = []) : void
    {
        // On extrait les données pour les rendre disponibles dans la vue
        extract($data);

        // Nombre de messages non lus, calculé une seule fois ici pour être disponible
        // sur TOUTES les pages (le header en a besoin partout, pas juste sur la messagerie)
        $unreadCount = 0;
        if (isset($_SESSION['user'])) {
            $messageManager = new MessageManager();
            $unreadCount = $messageManager->countUnreadForUser($_SESSION['user']['id']);
        }

        // Le chemin vers le template
        $content = TEMPLATE_VIEW_PATH . $template . '.php';

        // On charge le template principal
        require MAIN_VIEW_PATH;
    }
}