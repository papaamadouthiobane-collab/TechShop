<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

session_start();
require_once __DIR__ . '/../../../config/database.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->query("
    SELECT c.*, u.nom as nom_client 
    FROM commandes c 
    LEFT JOIN utilisateurs u ON c.utilisateur_id = u.id 
    ORDER BY c.created_at DESC
");
echo json_encode($stmt->fetchAll());
?>