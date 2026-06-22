<?php
// Helper: protège les endpoints API par rôle admin via JWT
// Utilisation: require_once __DIR__ . '/_auth_admin.php';

require_once __DIR__ . '/../config/jwt.php';

$headers = function_exists('apache_request_headers') ? apache_request_headers() : [];
$auth = $headers['Authorization'] ?? '';
$token = str_replace('Bearer ', '', $auth);

$userData = verifierToken($token);
if (!$userData) {
    http_response_code(401);
    echo json_encode(['error' => 'Non authentifié']);
    exit;
}

if (($userData['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Accès refusé']);
    exit;
}

// OK admin

