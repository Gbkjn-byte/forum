<?php
$chatFile = 'chats.txt';
$privateChatFile = 'private_chats.txt';
$nickname = $_GET['nickname'];

$chats = file($chatFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$privateChats = file($privateChatFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$chatList = [];

foreach ($chats as $chat) {
    list($chatId, $chatName) = explode('|', $chat);
    $chatList[] = ['id' => $chatId, 'name' => $chatName, 'private' => false];
}

foreach ($privateChats as $chat) {
    list($chatId, $chatName, $accessCode, $creator, $invitedUsers) = array_pad(explode('|', $chat), 5, '');
    $invitedUsersArray = explode(',', $invitedUsers);
    if ($creator === $nickname || in_array($nickname, $invitedUsersArray)) {
        $chatList[] = ['id' => $chatId, 'name' => $chatName, 'private' => true, 'creator' => $creator, 'invited_users' => $invitedUsersArray];
    }
}

echo json_encode($chatList);
?>
