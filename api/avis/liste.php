<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . '/../../config/database.php';

$produit_id = isset($_GET['produit_id']) ? (int)$_GET['produit_id'] : 0;

if($produit_id <= 0) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT a.*, u.nom as utilisateur_nom 
    FROM avis a 
    JOIN utilisateurs u ON a.utilisateur_id = u.id 
    WHERE a.produit_id = ? 
    ORDER BY a.created_at DESC
");
$stmt->execute([$produit_id]);
$avis = $stmt->fetchAll();

// Calculer la note moyenne
$stmt = $pdo->prepare("SELECT AVG(note) as moyenne FROM avis WHERE produit_id = ?");
$stmt->execute([$produit_id]);
$moyenne = $stmt->fetch()['moyenne'] ?? 0;

echo json_encode([
    'avis' => $avis,
    'moyenne' => round($moyenne, 1),
    'total' => count($avis)
]);
?>