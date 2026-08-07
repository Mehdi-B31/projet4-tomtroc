<?php

class MessageController {

    /**
     * Affiche la messagerie : liste des conversations à gauche, fil de discussion à droite.
     * Si aucune conversation n'est précisée dans l'URL, la plus récente est sélectionnée automatiquement.
     */
    public function showMessaging() : void {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        $conversationManager = new ConversationManager();
        $messageManager = new MessageManager();
        $userManager = new UserManager();

        $conversations = $conversationManager->getConversationsForUser($userId);

        // On enrichit chaque conversation avec les infos de l'autre utilisateur et le dernier message
        foreach ($conversations as &$conversation) {
            $otherUser = $userManager->getUserById((int) $conversation['other_user_id']);
            $conversation['other_username'] = $otherUser['username'] ?? 'Utilisateur inconnu';
            $conversation['other_avatar'] = $otherUser['avatar'] ?? null;

            $lastMessage = $messageManager->getLastMessage((int) $conversation['id']);
            $conversation['last_message_content'] = $lastMessage['content'] ?? '';
            $conversation['last_message_date'] = $lastMessage['date_creation'] ?? $conversation['date_creation'];
        }
        unset($conversation);

        $selectedId = isset($_GET['id']) ? (int) $_GET['id'] : ($conversations[0]['id'] ?? null);

        $selectedConversation = null;
        $otherUser = null;
        $messages = [];

        if ($selectedId) {
            $selectedConversation = $conversationManager->getConversationById($selectedId, $userId);

            if ($selectedConversation) {
                $otherUserId = (int) $selectedConversation['id_user1'] === $userId
                    ? (int) $selectedConversation['id_user2']
                    : (int) $selectedConversation['id_user1'];
                $otherUser = $userManager->getUserById($otherUserId);

                $messages = $messageManager->getMessagesByConversation($selectedId);
                $messageManager->markConversationAsRead($selectedId, $userId);
            }
        }

        $view = new View("Messagerie");
        $view->render("messaging", [
            'conversations' => $conversations,
            'selectedConversation' => $selectedConversation,
            'otherUser' => $otherUser,
            'messages' => $messages,
            'currentUserId' => $userId
        ]);
    }

    /**
     * Démarre (ou retrouve) une conversation avec un utilisateur donné, puis redirige vers celle-ci.
     * Appelé depuis "Envoyer un message" (détail livre / profil public).
     */
    public function startConversation() : void {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $targetUserId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($targetUserId <= 0 || $targetUserId === $userId) {
            header('Location: index.php?action=messaging');
            exit;
        }

        $conversationManager = new ConversationManager();
        $conversationId = $conversationManager->getOrCreateConversation($userId, $targetUserId);

        header('Location: index.php?action=messaging&id=' . $conversationId);
        exit;
    }

    /**
     * Traite l'envoi d'un nouveau message dans une conversation existante.
     */
    public function send() : void {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $conversationId = isset($_POST['id_conversation']) ? (int) $_POST['id_conversation'] : 0;
        $content = trim($_POST['content'] ?? '');

        if (empty($content) || $conversationId <= 0) {
            header('Location: index.php?action=messaging&id=' . $conversationId);
            exit;
        }

        $conversationManager = new ConversationManager();
        $conversation = $conversationManager->getConversationById($conversationId, $userId);

        if (!$conversation) {
            echo "Cette conversation n'existe pas.";
            return;
        }

        $receiverId = (int) $conversation['id_user1'] === $userId
            ? (int) $conversation['id_user2']
            : (int) $conversation['id_user1'];

        $messageManager = new MessageManager();
        $messageManager->sendMessage($conversationId, $userId, $receiverId, $content);

        header('Location: index.php?action=messaging&id=' . $conversationId);
        exit;
    }
}