<?php

class BookManager extends AbstractEntityManager {
    public function getLastBooks() : array {
        $sql = "SELECT book.*, user.username 
                FROM book 
                LEFT JOIN user ON book.id_user = user.id
                WHERE book.available = 1
                ORDER BY book.date_creation DESC
                LIMIT 4";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les livres appartenant à un utilisateur (pour "Mon compte").
     */
    public function getBooksByUser(int $userId) : array {
        $sql = "SELECT * FROM book WHERE id_user = :id_user ORDER BY date_creation DESC";
        $result = $this->db->query($sql, ['id_user' => $userId]);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les livres disponibles, avec filtre optionnel par titre.
     */
    public function getAllAvailableBooks(?string $search = null) : array {
        if ($search) {
            $sql = "SELECT book.*, user.username 
                    FROM book 
                    LEFT JOIN user ON book.id_user = user.id
                    WHERE book.available = 1 AND book.title LIKE :search
                    ORDER BY book.date_creation DESC";
            $result = $this->db->query($sql, ['search' => '%' . $search . '%']);
        } else {
            $sql = "SELECT book.*, user.username 
                    FROM book 
                    LEFT JOIN user ON book.id_user = user.id
                    WHERE book.available = 1
                    ORDER BY book.date_creation DESC";
            $result = $this->db->query($sql);
        }
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un livre par son id, avec les infos de son propriétaire (pour la page détail).
     */
    public function getBookWithOwner(int $bookId) : ?array {
        $sql = "SELECT book.*, user.id AS owner_id, user.username AS owner_username, user.avatar AS owner_avatar
                FROM book
                LEFT JOIN user ON book.id_user = user.id
                WHERE book.id = :id";
        $result = $this->db->query($sql, ['id' => $bookId]);
        $book = $result->fetch();
        return $book ?: null;
    }

    /**
     * Récupère un livre par son id, uniquement s'il appartient à l'utilisateur donné.
     * Retourne null si le livre n'existe pas ou n'appartient pas à cet utilisateur
     * (empêche un utilisateur d'éditer/voir le livre d'un autre en trafiquant l'id).
     */
    public function getBookByIdForUser(int $bookId, int $userId) : ?array {
        $sql = "SELECT * FROM book WHERE id = :id AND id_user = :id_user";
        $result = $this->db->query($sql, ['id' => $bookId, 'id_user' => $userId]);
        $book = $result->fetch();
        return $book ?: null;
    }

    /**
     * Supprime un livre, uniquement s'il appartient bien à l'utilisateur donné.
     */
    public function deleteBook(int $bookId, int $userId) : void {
        $sql = "DELETE FROM book WHERE id = :id AND id_user = :id_user";
        $this->db->query($sql, ['id' => $bookId, 'id_user' => $userId]);
    }

    /**
     * Ajoute un nouveau livre pour un utilisateur.
     */
    public function addBook(int $userId, string $title, string $author, string $description, int $available, ?string $image) : void {
        $sql = "INSERT INTO book (id_user, title, author, description, available, image, date_creation)
                VALUES (:id_user, :title, :author, :description, :available, :image, NOW())";
        $this->db->query($sql, [
            'id_user' => $userId,
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'available' => $available,
            'image' => $image
        ]);
    }

    /**
     * Met à jour un livre existant, uniquement s'il appartient à l'utilisateur donné.
     * L'image n'est mise à jour que si une nouvelle a été fournie (upload optionnel).
     */
    public function updateBook(int $bookId, int $userId, string $title, string $author, string $description, int $available, ?string $image) : void {
        if ($image) {
            $sql = "UPDATE book SET title = :title, author = :author, description = :description,
                    available = :available, image = :image
                    WHERE id = :id AND id_user = :id_user";
            $params = [
                'title' => $title,
                'author' => $author,
                'description' => $description,
                'available' => $available,
                'image' => $image,
                'id' => $bookId,
                'id_user' => $userId
            ];
        } else {
            $sql = "UPDATE book SET title = :title, author = :author, description = :description,
                    available = :available
                    WHERE id = :id AND id_user = :id_user";
            $params = [
                'title' => $title,
                'author' => $author,
                'description' => $description,
                'available' => $available,
                'id' => $bookId,
                'id_user' => $userId
            ];
        }
        $this->db->query($sql, $params);
    }
}