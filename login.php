<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];

    $users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($users as $user) {
        list($storedNickname, $storedPasswordHash) = explode('|', $user);
        if ($storedNickname === $nickname && password_verify($password, $storedPasswordHash)) {
            echo json_encode(['success' => true]);
            exit;
        }
    }

    echo json_encode(['success' => false]);
}
?>
