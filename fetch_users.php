<?php
$chat_id = $_GET['chat_id'];
$current_time = time();
$timeout = 30; // Тайм-аут 30 секунд для учета пользователей

$userFile = 'viewing_users.txt';
$users = file($userFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$chatUsers = [];

foreach ($users as $user) {
    list($userChatId, $nickname, $timestamp) = explode('|', $user);
    if ($userChatId == $chat_id && ($current_time - $timestamp) <= $timeout) {
        $chatUsers[] = ['nickname' => $nickname];
    }
}

echo json_encode($chatUsers);
?>
