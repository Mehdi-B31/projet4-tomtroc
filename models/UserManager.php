<?php

class UserManager extends AbstractEntityManager
{

    /**
     * Ajoute un utilisateur en BDD.
     */
    public function addUser(string $username, string $email, string $password) : void
    {
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
    public function getUserByEmail(string $email) : ?array
    {
        $sql = "SELECT * FROM user WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        $user = $result->fetch();
        return $user ?: null;
    }

    /**
     * Recupere un utilisateur par son id.
     */
    public function getUserById(int $id) : ?array
    {
        $sql = "SELECT * FROM user WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $user = $result->fetch();
        return $user ?: null;
    }

    /**
     * Met à jour le profil (email, pseudo, et mot de passe uniquement si renseigné).
     */
    public function updateProfile(int $id, string $username, string $email, ?string $password = null) : void
    {
        if ($password) {
            $sql = "UPDATE user SET username = :username, email = :email, password = :password WHERE id = :id";
            $this->db->query($sql, [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'id' => $id
            ]);
        } else {
            $sql = "UPDATE user SET username = :username, email = :email WHERE id = :id";
            $this->db->query($sql, [
                'username' => $username,
                'email' => $email,
                'id' => $id
            ]);
        }
    }
}