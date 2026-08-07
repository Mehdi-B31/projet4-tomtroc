<?php

class MessageManager extends AbstractEntityManager {

    /**
     * Récupère tous les messages d'une conversation, du plus ancien au plus récent.
     */
    public function getMessagesByConversation(int $conversationId) : array {
        $sql = "SELECT * FROM message WHERE id_conversation = :id ORDER BY date_creation ASC";
        $result = $this->db->query($sql, ['id' => $conversationId]);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère le dernier message d'une conversation (pour l'aperçu dans la liste).
     */
    public function getLastMessage(int $conversationId) : ?array {
        $sql = "SELECT * FROM message WHERE id_conversation = :id ORDER BY date_creation DESC LIMIT 1";
        $result = $this->db->query($sql, ['id' => $conversationId]);
        $message = $result->fetch();
        return $message ?: null;
    }

    /**
     * Envoie un nouveau message dans une conversation.
     */
    public function sendMessage(int $conversationId, int $senderId, int $receiverId, string $content) : void {
        $sql = "INSERT INTO message (id_conversation, id_sender, id_receiver, content, date_creation, is_read)
                VALUES (:conversation_id, :sender_id, :receiver_id, :content, NOW(), 0)";
        $this->db->query($sql, [
            'conversation_id' => $conversationId,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'content' => $content
        ]);
    }

    /**
     * Marque comme lus tous les messages d'une conversation reçus par cet utilisateur.
     */
    public function markConversationAsRead(int $conversationId, int $userId) : void {
        $sql = "UPDATE message SET is_read = 1 WHERE id_conversation = :id AND id_receiver = :user_id";
        $this->db->query($sql, ['id' => $conversationId, 'user_id' => $userId]);
    }

    /**
     * Compte le nombre total de messages non lus pour un utilisateur (pour le badge du header).
     */
    public function countUnreadForUser(int $userId) : int {
        $sql = "SELECT COUNT(*) AS nb FROM message WHERE id_receiver = :user_id AND is_read = 0";
        $result = $this->db->query($sql, ['user_id' => $userId]);
        $row = $result->fetch();
        return (int) $row['nb'];
    }
}