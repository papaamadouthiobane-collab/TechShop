<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Non autorisé']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$stats = [];

// Nombre de produits
$stmt = $pdo->query("SELECT COUNT(*) as total FROM produits");
$stats['produits'] = $stmt->fetch()['total'];

// Nombre de commandes
$stmt = $pdo->query("SELECT COUNT(*) as total FROM commandes");
$stats['commandes'] = $stmt->fetch()['total'];

// Nombre d'utilisateurs
$stmt = $pdo->query("SELECT COUNT(*) as total FROM utilisateurs");
$stats['utilisateurs'] = $stmt->fetch()['total'];

// Chiffre d'affaires (commandes livrées)
$stmt = $pdo->query("SELECT SUM(total) as ca FROM commandes WHERE statut = 'livree'");
$stats['ca'] = $stmt->fetch()['ca'] ?? 0;

echo json_encode($stats);
?>