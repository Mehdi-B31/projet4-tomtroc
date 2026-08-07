<?php
function formatConversationDate(string $dateString) : string {
    $date = new DateTime($dateString);
    $today = new DateTime('today');
    if ($date >= $today) {
        return $date->format('H:i');
    }
    return $date->format('d.m');
}

function formatMessageDate(string $dateString) : string {
    $date = new DateTime($dateString);
    return $date->format('d.m H:i');
}
?>

<div class="messaging-page">
    <!-- SIDEBAR : LISTE DES CONVERSATIONS -->
    <div class="messaging-sidebar">
        <div class="messaging-sidebar-header">
            <h1 class="messaging-title">Messagerie</h1>
        </div>

        <?php if (empty($conversations)) : ?>
        <p class="messaging-empty">Aucune conversation pour l'instant.</p>
        <?php endif; ?>

        <?php foreach ($conversations as $conversation) : ?>
        <?php
            $isActive = $selectedConversation && (int) $selectedConversation['id'] === (int) $conversation['id'];
            $avatarPath = $conversation['other_avatar'] ? '/assets/images/avatars/' . htmlspecialchars($conversation['other_avatar']) : '/assets/images/default-avatar.jpg';
        ?>
        <a href="index.php?action=messaging&id=<?= $conversation['id'] ?>" class="conversation-item <?= $isActive ? 'conversation-item-active' : '' ?>">
            <img src="<?= $avatarPath ?>" alt="<?= htmlspecialchars($conversation['other_username']) ?>" class="conversation-avatar">
            <div class="conversation-info">
                <div class="conversation-top-row">
                    <span class="conversation-name"><?= htmlspecialchars($conversation['other_username']) ?></span>
                    <span class="conversation-time"><?= formatConversationDate($conversation['last_message_date']) ?></span>
                </div>
                <p class="conversation-preview"><?= htmlspecialchars(mb_strimwidth($conversation['last_message_content'], 0, 30, '...')) ?></p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- FIL DE DISCUSSION -->
    <div class="messaging-chat">
        <?php if ($selectedConversation && $otherUser) : ?>
        <?php $otherAvatarPath = $otherUser['avatar'] ? '/assets/images/avatars/' . htmlspecialchars($otherUser['avatar']) : '/assets/images/default-avatar.jpg'; ?>

        <div class="messaging-chat-header">
            <img src="<?= $otherAvatarPath ?>" alt="<?= htmlspecialchars($otherUser['username']) ?>" class="conversation-avatar">
            <span class="messaging-chat-header-name"><?= htmlspecialchars($otherUser['username']) ?></span>
        </div>

        <div class="messaging-thread">
            <?php foreach ($messages as $message) : ?>
            <?php $isSent = (int) $message['id_sender'] === (int) $currentUserId; ?>
            <div class="message-row <?= $isSent ? 'message-row-sent' : 'message-row-received' ?>">
                <?php if (!$isSent) : ?>
                <div class="message-received-header">
                    <img src="<?= $otherAvatarPath ?>" alt="" class="avatar-mini-msg">
                    <span class="message-meta"><?= formatMessageDate($message['date_creation']) ?></span>
                </div>
                <?php else : ?>
                <span class="message-meta"><?= formatMessageDate($message['date_creation']) ?></span>
                <?php endif; ?>
                <div class="message-bubble <?= $isSent ? 'message-bubble-sent' : 'message-bubble-received' ?>">
                    <?= htmlspecialchars($message['content']) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <form action="index.php?action=message_send" method="post" class="messaging-input-row">
            <input type="hidden" name="id_conversation" value="<?= $selectedConversation['id'] ?>">
            <input type="text" name="content" placeholder="Tapez votre message ici" required class="messaging-input">
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>

        <?php else : ?>
        <p class="messaging-empty">Sélectionnez une conversation pour commencer à discuter.</p>
        <?php endif; ?>
    </div>
</div>