<?php
$chatFile = 'chats.txt';
$chats = file($chatFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$chatList = [];

foreach ($chats as $chat) {
    list($chatId, $chatName) = explode('|', $chat);
    $chatList[] = ['id' => $chatId, 'name' => $chatName];
}

echo json_encode($chatList);
?>
