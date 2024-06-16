<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $access_code = $_POST['access_code'];
    $nickname = localStorage.getItem('nickname');

    $privateChatFile = 'private_chats.txt';
    $privateChats = file($privateChatFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($privateChats as $chat) {
        list($privateChatId, $privateChatName, $storedAccessCode, $invitedUsers) = explode('|', $chat);
        $invitedUsersArray = array_map('trim', explode(',', $invitedUsers));
        if ($access_code === $storedAccessCode || in_array($nickname, $invitedUsersArray)) {
            echo json_encode(['success' => true, 'chat_id' => $privateChatId, 'chat_name' => $privateChatName]);
            exit;
        }
    }
    echo json_encode(['success' => false]);
}
?>
