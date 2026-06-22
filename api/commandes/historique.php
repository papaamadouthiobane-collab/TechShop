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

// Récupérer les commandes avec les articles
$stmt = $pdo->prepare("
    SELECT c.*, 
           (SELECT COUNT(*) FROM lignes_commande WHERE commande_id = c.id) as nb_articles
    FROM commandes c 
    WHERE c.utilisateur_id = ? 
    ORDER BY c.created_at DESC
");
$stmt->execute([$userId]);
$commandes = $stmt->fetchAll();

foreach($commandes as &$c) {
    $stmt = $pdo->prepare("
        SELECT lc.*, p.nom, p.image_url, p.prix as produit_prix
        FROM lignes_commande lc 
        JOIN produits p ON lc.produit_id = p.id 
        WHERE lc.commande_id = ?
    ");
    $stmt->execute([$c['id']]);
    $c['articles'] = $stmt->fetchAll();
}

echo json_encode($commandes);
?>