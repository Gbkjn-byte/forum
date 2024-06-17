<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $private_chat_name = $_POST['chat_name'];
    $creator = $_POST['nickname'];

    // Генерация уникального идентификатора для приватного чата
    $private_chat_id = uniqid('private_');

    // Генерация уникального кода для доступа к приватному чату
    $access_code = bin2hex(random_bytes(4));

    // Запись нового приватного чата в файл
    $chatLine = "$private_chat_id|$private_chat_name|$access_code|$creator|" . PHP_EOL;
    file_put_contents('private_chats.txt', $chatLine, FILE_APPEND);

    echo json_encode(['success' => true, 'access_code' => $access_code]);
}
?>
