<?php

class BookManager extends AbstractEntityManager {
    public function getAllBooks() : array {
        $sql = "SELECT * FROM book";
        $result = $this->db->query($sql);
        $books = [];
        while ($book = $result->fetch()) {
            $books[] = $book;
        }
        return $books;
    }
}