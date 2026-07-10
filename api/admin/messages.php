<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

session_start();
require_once __DIR__ . '/../../config/database.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
echo json_encode($stmt->fetchAll());
?>