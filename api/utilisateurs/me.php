<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Authorization");

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';

$headers = apache_request_headers();
$token = str_replace('Bearer ', '', $headers['Authorization'] ?? '');

$userData = verifierToken($token);
if(!$userData) {
    http_response_code(401);
    echo json_encode(['error' => 'Non authentifié']);
    exit;
}

$stmt = $pdo->prepare("SELECT id, nom, email, telephone, role, adresse, created_at FROM utilisateurs WHERE id = ?");
$stmt->execute([$userData['id']]);
$user = $stmt->fetch();

if($user) {
    echo json_encode($user);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Utilisateur non trouvé']);
}
?>