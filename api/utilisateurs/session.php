<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/jwt.php';

$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? '';

$userData = verifierToken($token);
if($userData) {
    $_SESSION['user_id'] = $userData['id'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['role'] = $userData['role'];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>