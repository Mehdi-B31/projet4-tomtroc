<?php

class ConversationManager extends AbstractEntityManager
{

    /**
     * Retourne l'id de la conversation entre 2 utilisateurs si elle existe déjà,
     * sinon en crée une nouvelle et retourne son id.
     * Le OR dans le WHERE gère le fait que Mehdi->Alice et Alice->Mehdi
     * doivent pointer vers la même conversation.
     */
    public function getOrCreateConversation(int $userA, int $userB) : int
    {
        $sql = "SELECT id FROM conversation 
                WHERE (id_user1 = :a AND id_user2 = :b) 
                   OR (id_user1 = :b AND id_user2 = :a)";
        $result = $this->db->query($sql, ['a' => $userA, 'b' => $userB]);
        $conversation = $result->fetch();

        if ($conversation) {
            return (int) $conversation['id'];
        }

        $sql = "INSERT INTO conversation (id_user1, id_user2, date_creation) VALUES (:a, :b, NOW())";
        $this->db->query($sql, ['a' => $userA, 'b' => $userB]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Retourne toutes les conversations d'un utilisateur, triées de la plus récente à la plus ancienne.
     */
    public function getConversationsForUser(int $userId) : array
    {
        $sql = "SELECT *,
                CASE WHEN id_user1 = :user_id THEN id_user2 ELSE id_user1 END AS other_user_id
                FROM conversation
                WHERE id_user1 = :user_id OR id_user2 = :user_id
                ORDER BY date_creation DESC";
        $result = $this->db->query($sql, ['user_id' => $userId]);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une conversation par son id, uniquement si l'utilisateur donné
     * en fait bien partie (empêche de consulter la conversation de quelqu'un d'autre).
     */
    public function getConversationById(int $conversationId, int $userId) : ?array
    {
        $sql = "SELECT * FROM conversation 
                WHERE id = :id AND (id_user1 = :user_id OR id_user2 = :user_id)";
        $result = $this->db->query($sql, ['id' => $conversationId, 'user_id' => $userId]);
        $conversation = $result->fetch();
        return $conversation ?: null;
    }
}