<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Пароли не совпадают']);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $userData = "$nickname|$hashedPassword\n";

    file_put_contents('users.txt', $userData, FILE_APPEND | LOCK_EX);

    echo json_encode(['success' => true]);
}
?>
