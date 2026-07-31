<?php

class HomeController {
    public function showHome() {
        $bookManager = new BookManager();
        $books = $bookManager->getAllBooks();
        
        foreach ($books as $book) {
            echo $book['title'] . ' - ' . $book['author'] . '<br>';
        }
    }
}