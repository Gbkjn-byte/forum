<?php
$chat_id = $_GET['chat_id'];

// Ожидаем, что файл users.txt содержит данные в формате:
// nickname|hashed_password

$users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$chatUsers = [];

// Для примера, создадим массив, который будет хранить информацию о пользователях и чате, который они просматривают
// В реальной системе эта информация должна обновляться, когда пользователь начинает просматривать чат
$viewingUsers = [
    '1' => ['Gbkjn_', 'kjhrd'], // Например, пользователи, просматривающие чат с id 1
    '2' => ['Это ник'], // Например, пользователь, просматривающий чат с id 2
];

if (isset($viewingUsers[$chat_id])) {
    foreach ($viewingUsers[$chat_id] as $nickname) {
        foreach ($users as $user) {
            list($storedNickname, $storedPasswordHash) = explode('|', $user);
            if ($storedNickname === $nickname) {
                $chatUsers[] = ['nickname' => $storedNickname];
                break;
            }
        }
    }
}

echo json_encode($chatUsers);
?>
