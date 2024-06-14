<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['chat_name'])) {
    $chat_name = htmlspecialchars($_POST['chat_name'], ENT_QUOTES, 'UTF-8');
    $chats_file = 'chats.json';
    $chats = json_decode(file_get_contents($chats_file), true);
    $new_chat_id = end($chats)['id'] + 1;
    $chats[] = ['id' => $new_chat_id, 'name' => $chat_name];
    file_put_contents($chats_file, json_encode($chats));
}
header('Location: index.php');
exit();
?>
