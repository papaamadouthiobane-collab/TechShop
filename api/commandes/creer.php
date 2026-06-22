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
$adresse = $data['adresse'] ?? '';

if(empty($adresse)) {
    http_response_code(400);
    echo json_encode(['error' => 'Adresse de livraison requise']);
    exit;
}

try {
    $pdo->beginTransaction();
    
    // Récupérer le panier
    $stmt = $pdo->prepare("SELECT id FROM paniers WHERE utilisateur_id = ?");
    $stmt->execute([$userId]);
    $panier = $stmt->fetch();
    
    if(!$panier) {
        throw new Exception('Panier non trouvé');
    }
    
    // Récupérer les lignes panier
    $stmt = $pdo->prepare("
        SELECT lp.*, p.prix, p.stock, p.nom 
        FROM lignes_panier lp 
        JOIN produits p ON lp.produit_id = p.id 
        WHERE lp.panier_id = ?
    ");
    $stmt->execute([$panier['id']]);
    $lignes = $stmt->fetchAll();
    
    if(count($lignes) == 0) {
        throw new Exception('Panier vide');
    }
    
    // Calculer total et vérifier stock
    $total = 0;
    foreach($lignes as $ligne) {
        if($ligne['quantite'] > $ligne['stock']) {
            throw new Exception("Stock insuffisant pour {$ligne['nom']}");
        }
        $total += $ligne['quantite'] * $ligne['prix_unitaire'];
    }
    
    // Générer numéro de commande
    $numero = 'CMD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    
    // Créer la commande
    $stmt = $pdo->prepare("
        INSERT INTO commandes (utilisateur_id, numero_commande, total, adresse_livraison, statut) 
        VALUES (?, ?, ?, ?, 'en_attente')
    ");
    $stmt->execute([$userId, $numero, $total, $adresse]);
    $commandeId = $pdo->lastInsertId();
    
    // Transférer les lignes
    $stmt = $pdo->prepare("
        INSERT INTO lignes_commande (commande_id, produit_id, quantite, prix_unitaire) 
        VALUES (?, ?, ?, ?)
    ");
    foreach($lignes as $ligne) {
        $stmt->execute([$commandeId, $ligne['produit_id'], $ligne['quantite'], $ligne['prix_unitaire']]);
        
        // Décrémenter le stock
        $update = $pdo->prepare("UPDATE produits SET stock = stock - ? WHERE id = ?");
        $update->execute([$ligne['quantite'], $ligne['produit_id']]);
    }
    
    // Vider le panier
    $stmt = $pdo->prepare("DELETE FROM lignes_panier WHERE panier_id = ?");
    $stmt->execute([$panier['id']]);
    
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Commande créée',
        'numero' => $numero,
        'total' => $total
    ]);
    
} catch(Exception $e) {
    $pdo->rollBack();
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>