<?php
$data = json_decode(file_get_contents('php://input'), true);
$nickname = $data['nickname'];
$chat_id = $data['chat_id'];
$timestamp = time();

$userFile = 'viewing_users.txt';
$lines = file($userFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$newLines = [];
$updated = false;

// Удаляем старые записи о пользователе в других чатах
foreach ($lines as $line) {
    list($existingChatId, $existingNickname, $existingTimestamp) = explode('|', $line);
    if ($existingNickname === $nickname) {
        if ($existingChatId === $chat_id) {
            $newLines[] = "$chat_id|$nickname|$timestamp";
            $updated = true;
        }
        // Не добавляем старые записи о пользователе
    } else {
        $newLines[] = $line;
    }
}

if (!$updated) {
    $newLines[] = "$chat_id|$nickname|$timestamp";
}

file_put_contents($userFile, implode(PHP_EOL, $newLines) . PHP_EOL);
?>
