<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chat_id = $_POST['chat_id'];
    $nickname = $_POST['nickname'];

    $privateChatFile = 'private_chats.txt';
    $privateChats = file($privateChatFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $newContent = [];

    foreach ($privateChats as $chat) {
        list($privateChatId, $privateChatName, $storedAccessCode, $creator, $invitedUsers) = array_pad(explode('|', $chat), 5, '');
        if ($privateChatId === $chat_id) {
            $invitedUsers = trim($invitedUsers) ? "$invitedUsers,$nickname" : $nickname;
            $newLine = "$privateChatId|$privateChatName|$storedAccessCode|$creator|$invitedUsers";
            $newContent[] = $newLine;
        } else {
            $newContent[] = $chat;
        }
    }

    file_put_contents($privateChatFile, implode(PHP_EOL, $newContent) . PHP_EOL);
    echo json_encode(['success' => true]);
}
?>
