<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message']) && !empty($_POST['chat_id']) && !empty($_POST['nickname'])) {
    if (!empty($_POST['nickname'])) {
        $_SESSION['nickname'] = htmlspecialchars($_POST['nickname'], ENT_QUOTES, 'UTF-8');
    }
    $nickname = $_POST['nickname']
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
    $chat_id = intval($_POST['chat_id']);
    $class = 'user'; // Все сообщения отправляются пользователем
    $content = "<div class='nickname'>{$nickname}</div><div class='message'>{$message}</div>";
    $filename = "posts/{$chat_id}_" . '.txt';
    file_put_contents($filename, "<div class='post {$class}'>{$content}</div>");
}
?>
