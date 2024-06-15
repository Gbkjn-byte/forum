<?php
$chat_id = $_GET['chat_id'];

// Ожидаем, что файл posts.txt содержит данные в формате:
// chat_id|nickname|message

$posts = file('posts.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$chatPosts = [];

foreach ($posts as $post) {
    list($postChatId, $nickname, $message) = explode('|', $post);
    if ($postChatId == $chat_id) {
        $chatPosts[] = ['nickname' => $nickname, 'message' => $message];
    }
}

echo json_encode($chatPosts);
?>
