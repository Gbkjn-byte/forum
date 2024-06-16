<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chat_id = $_POST['chat_id'];
    $nickname = $_POST['nickname'];

    // Проверка, что пользователь существует
    $userFile = 'users.txt';
    $userExists = false;
    if (file_exists($userFile)) {
        $users = file($userFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($users as $user) {
            list($existingNickname, $passwordHash) = explode('|', $user);
            if ($existingNickname == $nickname) {
                $userExists = true;
                break;
            }
        }
    }

    if ($userExists) {
        // Добавление пользователя в чат
        $userChatLine = "$chat_id|$nickname" . PHP_EOL;
        file_put_contents('user_chats.txt', $userChatLine, FILE_APPEND);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Пользователь не найден']);
    }
}
?>
