<?php
$chatId = $_GET['chat_id'];
$postsFile = 'posts.txt';

$posts = file($postsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$chatPosts = [];

foreach ($posts as $post) {
    list($postChatId, $nickname, $message) = explode('|', $post);
    if ($postChatId === $chatId) {
        $chatPosts[] = ['nickname' => $nickname, 'message' => $message];
    }
}

echo json_encode($chatPosts);
?>
