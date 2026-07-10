<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

session_start();
require_once __DIR__ . '/../../config/database.php';

if(!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Connectez-vous pour laisser un avis']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$produit_id = $data['produit_id'] ?? 0;
$note = $data['note'] ?? 0;
$commentaire = trim($data['commentaire'] ?? '');

if($produit_id <= 0 || $note < 1 || $note > 5 || empty($commentaire)) {
    http_response_code(400);
    echo json_encode(['error' => 'Données invalides']);
    exit;
}

// Vérifier si l'utilisateur a déjà acheté ce produit (optionnel)
// Ici on autorise tout le monde à laisser un avis

$stmt = $pdo->prepare("
    INSERT INTO avis (produit_id, utilisateur_id, note, commentaire) 
    VALUES (?, ?, ?, ?)
");
$stmt->execute([$produit_id, $_SESSION['user_id'], $note, $commentaire]);

echo json_encode(['success' => true, 'message' => 'Avis ajouté avec succès']);
?>