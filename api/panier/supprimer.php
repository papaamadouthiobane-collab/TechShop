<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");

session_start();
require_once __DIR__ . '/../../config/database.php';

if(!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Non authentifié']);
    exit;
}

$userId = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);
$produitId = $data['produit_id'] ?? 0;

$stmt = $pdo->prepare("SELECT id FROM paniers WHERE utilisateur_id = ?");
$stmt->execute([$userId]);
$panier = $stmt->fetch();

if($panier) {
    $stmt = $pdo->prepare("DELETE FROM lignes_panier WHERE panier_id = ? AND produit_id = ?");
    $stmt->execute([$panier['id'], $produitId]);
}

echo json_encode(['success' => true]);
?>