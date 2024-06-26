<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];

    $userFile = 'users.txt';
    $userExists = false;
    if (file_exists($userFile)) {
        $users = file($userFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($users as $user) {
            list($existingNickname, $passwordHash) = explode('|', $user);
            if ($existingNickname == $nickname && password_verify($password, $passwordHash)) {
                $userExists = true;
                break;
            }
        }
    }

    if ($userExists) {
        setcookie('nickname', $nickname, time() + (86400 * 30), "/"); // 86400 = 1 day
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
