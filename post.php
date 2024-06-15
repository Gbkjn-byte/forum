<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chat_id = $_POST['chat_id'];
    $nickname = $_POST['nickname'];
    $message = trim($_POST['message']);

    if (!empty($message)) {
        $messageLine = $chat_id . '|' . $nickname . '|' . $message . PHP_EOL;
        file_put_contents('posts.txt', $messageLine, FILE_APPEND);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Пустое сообщение']);
    }
}
?>
