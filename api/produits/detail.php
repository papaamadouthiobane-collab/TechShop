<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../_auth_admin.php';

$imagesParMarque = [
    'Apple' => 'https://images.unsplash.com/photo-1591337676887-a217a6970a8a?w=600&h=400&fit=crop',
    'Samsung' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=600&h=400&fit=crop',
    'Dell' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&h=400&fit=crop',
    'Sony' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=600&h=400&fit=crop',
    'Google' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=600&h=400&fit=crop',
    'Xiaomi' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=600&h=400&fit=crop',
    'Lenovo' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&h=400&fit=crop',
    'HP' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&h=400&fit=crop',
    'Asus' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&h=400&fit=crop',
];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID requis']);
    exit;
}

$stmt = $pdo->prepare("
    SELECT p.*, c.nom as categorie_nom 
    FROM produits p 
    LEFT JOIN categories c ON p.categorie_id = c.id 
    WHERE p.id = ?
");
$stmt->execute([$id]);
$produit = $stmt->fetch();

if($produit) {
    global $imagesParMarque;
    $produit['image'] = $imagesParMarque[$produit['marque']] ?? 'https://placehold.co/600x400/1e3a8a/white?text=' . urlencode($produit['nom']);
    echo json_encode($produit);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Produit non trouvé']);
}
?>