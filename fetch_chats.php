<?php
$chats_file = 'chats.json';
if (!file_exists($chats_file)) {
    $chats = [
        ['id' => 1, 'name' => 'Общий чат'],
        ['id' => 2, 'name' => 'Чат разработчиков'],
        ['id' => 3, 'name' => 'Чат дизайнеров'],
    ];
    file_put_contents($chats_file, json_encode($chats));
} else {
    $chats = json_decode(file_get_contents($chats_file), true);
}

echo json_encode($chats);
?>
