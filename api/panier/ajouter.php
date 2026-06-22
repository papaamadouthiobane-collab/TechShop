<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
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

$stmt = $pdo->prepare("SELECT prix FROM produits WHERE id = ?");
$stmt->execute([$produitId]);
$produit = $stmt->fetch();

if(!$produit) {
    http_response_code(404);
    echo json_encode(['error' => 'Produit non trouvé']);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM paniers WHERE utilisateur_id = ?");
$stmt->execute([$userId]);
$panier = $stmt->fetch();

if(!$panier) {
    $stmt = $pdo->prepare("INSERT INTO paniers (utilisateur_id) VALUES (?)");
    $stmt->execute([$userId]);
    $panierId = $pdo->lastInsertId();
} else {
    $panierId = $panier['id'];
}

$stmt = $pdo->prepare("SELECT id, quantite FROM lignes_panier WHERE panier_id = ? AND produit_id = ?");
$stmt->execute([$panierId, $produitId]);
$ligne = $stmt->fetch();

if($ligne) {
    $newQuantite = $ligne['quantite'] + $quantite;
    $stmt = $pdo->prepare("UPDATE lignes_panier SET quantite = ? WHERE id = ?");
    $stmt->execute([$newQuantite, $ligne['id']]);
} else {
    $stmt = $pdo->prepare("INSERT INTO lignes_panier (panier_id, produit_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)");
    $stmt->execute([$panierId, $produitId, $quantite, $produit['prix']]);
}

echo json_encode(['success' => true, 'message' => 'Produit ajouté au panier']);
?>