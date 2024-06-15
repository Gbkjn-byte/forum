<?php
session_start();
header('Content-Type: application/json');

$nickname = trim($_POST['nickname']);
$password = trim($_POST['password']);

// Проверка корректности данных
if (empty($nickname) || empty($password)) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit;
}

// Проверка данных в БД (пример)
$conn = new mysqli('localhost', 'root', '', 'chat_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT password FROM users WHERE nickname = ?");
$stmt->bind_param('s', $nickname);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashed_password);
$stmt->fetch();

if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
    $_SESSION['nickname'] = $nickname;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
}

$stmt->close();
$conn->close();
?>
