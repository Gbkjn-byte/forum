<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chat_name = $_POST['chat_name'];
    $is_private = isset($_POST['is_private']) && $_POST['is_private'] === 'true';

    // Генерация уникального идентификатора для чата
    $chat_id = uniqid();

    // Запись нового чата в файл
    $chatLine = "$chat_id|$chat_name|$is_private" . PHP_EOL;
    file_put_contents('chats.txt', $chatLine, FILE_APPEND);

    echo json_encode(['success' => true]);
}
?>
