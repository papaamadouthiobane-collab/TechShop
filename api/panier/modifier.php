<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
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
$quantite = $data['quantite'] ?? 1;

$stmt = $pdo->prepare("SELECT id FROM paniers WHERE utilisateur_id = ?");
$stmt->execute([$userId]);
$panier = $stmt->fetch();

if(!$panier) {
    http_response_code(404);
    echo json_encode(['error' => 'Panier non trouvé']);
    exit;
}

// Met à jour la quantité et recalcule/préserve le prix unitaire
$stmt = $pdo->prepare("SELECT prix_unitaire FROM lignes_panier WHERE panier_id = ? AND produit_id = ?");
$stmt->execute([$panier['id'], $produitId]);
$ligne = $stmt->fetch();

if(!$ligne) {
    http_response_code(404);
    echo json_encode(['error' => 'Ligne panier non trouvée']);
    exit;
}

// Reprendre le prix courant du produit pour éviter un champ prix_unitaire NULL/incohérent
$stmt = $pdo->prepare("SELECT prix FROM produits WHERE id = ?");
$stmt->execute([$produitId]);
$produit = $stmt->fetch();

if(!$produit) {
    http_response_code(404);
    echo json_encode(['error' => 'Produit non trouvé']);
    exit;
}

$stmt = $pdo->prepare("UPDATE lignes_panier SET quantite = ?, prix_unitaire = ? WHERE panier_id = ? AND produit_id = ?");
$stmt->execute([$quantite, $produit['prix'], $panier['id'], $produitId]);

echo json_encode(['success' => true]);
?>
