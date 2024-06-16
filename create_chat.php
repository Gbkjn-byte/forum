<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chat_name = $_POST['chat_name'];

    // Генерация уникального идентификатора для чата
    $chat_id = uniqid();

    // Запись нового чата в файл
    $chatLine = "$chat_id|$chat_name" . PHP_EOL;
    file_put_contents('chats.txt', $chatLine, FILE_APPEND);

    echo json_encode(['success' => true]);
}
?>
