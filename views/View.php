<?php

class View {
    private $title;

    public function __construct(string $title) {
        $this->title = $title;
    }

    public function render(string $template, array $data = []) : void {
        // On extrait les données pour les rendre disponibles dans la vue
        extract($data);
        
        // Le chemin vers le template
        $content = TEMPLATE_VIEW_PATH . $template . '.php';
        
        // On charge le template principal
        require MAIN_VIEW_PATH;
    }
}