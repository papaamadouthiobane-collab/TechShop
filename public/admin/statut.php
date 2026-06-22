<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

session_start();
require_once __DIR__ . '/../../../config/database.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Non autorisé']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$commandeId = $data['commande_id'] ?? 0;
$statut = $data['statut'] ?? '';

$stmt = $pdo->prepare("UPDATE commandes SET statut = ? WHERE id = ?");
$stmt->execute([$statut, $commandeId]);

echo json_encode(['success' => true]);
?>