<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

session_start();
require_once __DIR__ . '/../../config/database.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Non autorisé']);
    exit;
}

$stats = [];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM produits");
$stats['produits'] = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM commandes");
$stats['commandes'] = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM utilisateurs");
$stats['utilisateurs'] = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT SUM(total) as ca FROM commandes WHERE statut = 'livree'");
$stats['ca'] = $stmt->fetch()['ca'] ?? 0;

$stmt = $pdo->query("SELECT COUNT(*) as total FROM messages WHERE lu = 0");
$stats['messages_non_lus'] = $stmt->fetch()['total'] ?? 0;

echo json_encode($stats);
?>