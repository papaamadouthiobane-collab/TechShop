<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$nom = $data['nom'] ?? '';
$email = $data['email'] ?? '';
$password = $data['mot_de_passe'] ?? '';
$telephone = $data['telephone'] ?? '';

if (empty($nom) || empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(['error' => 'Nom, email et mot de passe requis']);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    http_response_code(409);
    echo json_encode(['error' => 'Cet email est déjà utilisé']);
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, telephone) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$nom, $email, $hashed, $telephone])) {
    $userId = $pdo->lastInsertId();
    $pdo->prepare("INSERT INTO paniers (utilisateur_id) VALUES (?)")->execute([$userId]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Inscription réussie',
        'user' => [
            'id' => $userId,
            'nom' => $nom,
            'email' => $email,
            'role' => 'client'
        ]
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de l\'inscription']);
}
?>