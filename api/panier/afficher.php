<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

session_start();
require_once __DIR__ . '/../../config/database.php';

if(!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT id FROM paniers WHERE utilisateur_id = ?");
$stmt->execute([$userId]);
$panier = $stmt->fetch();

if(!$panier) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT lp.*, p.nom, p.prix, p.image_url 
    FROM lignes_panier lp 
    JOIN produits p ON lp.produit_id = p.id 
    WHERE lp.panier_id = ?
");
$stmt->execute([$panier['id']]);
$lignes = $stmt->fetchAll();

echo json_encode($lignes);
?>