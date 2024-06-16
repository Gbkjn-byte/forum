<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chat_id = $_POST['chat_id'];
    $nickname = $_POST['nickname'];
    $access_code = isset($_POST['access_code']) ? $_POST['access_code'] : '';

    $privateChatFile = 'private_chats.txt';
    $privateChats = file($privateChatFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($privateChats as $chat) {
        list($privateChatId, $privateChatName, $storedAccessCode, $invitedUsers) = explode('|', $chat);
        if ($privateChatId === $chat_id) {
            $invitedUsersArray = array_map('trim', explode(',', $invitedUsers));
            if ($access_code === $storedAccessCode || in_array($nickname, $invitedUsersArray)) {
                echo json_encode(['access' => true]);
                exit;
            }
        }
    }
    echo json_encode(['access' => false]);
}
?>
