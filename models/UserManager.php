<?php

class UserManager extends AbstractEntityManager {

    /**
     * Ajoute un utilisateur en BDD.
     */
    public function addUser(string $username, string $email, string $password) : void {
        $sql = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";
        $this->db->query($sql, [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    /**
     * Recupere un utilisateur par son email.
     */
    public function getUserByEmail(string $email) : ?array {
        $sql = "SELECT * FROM user WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        $user = $result->fetch();
        return $user ?: null;
    }
}