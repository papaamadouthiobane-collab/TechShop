<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . '/../../config/database.php';

function getImageForProduct($nom, $marque) {
    $nom_lower = strtolower($nom);
    $specific = [
        'iphone 15 pro max' => 'iphone_15_pro_max.jpg',
        'iphone 15 pro' => 'iphone_15_pro.jpg',
        'iphone 15 plus' => 'iphone_15_plus.jpg',
        'iphone 15' => 'iphone_15.jpg',
        'iphone 14 pro max' => 'iphone_14_pro_max.jpg',
        'iphone 14 plus' => 'iphone_14_plus.jpg',
        'iphone 14' => 'iphone_14.jpg',
        'iphone se' => 'iphone_se.jpg',
        'samsung galaxy s24 ultra' => 'samsung_s24_ultra.jpg',
        'samsung galaxy s24 plus' => 'samsung_s24_plus.jpg',
        'samsung galaxy s24' => 'samsung_s24.jpg',
        'samsung galaxy s23 ultra' => 'samsung_s23_ultra.jpg',
        'samsung galaxy z fold' => 'samsung_z_fold5.jpg',
        'samsung galaxy z flip' => 'samsung_z_flip5.jpg',
        'macbook pro m3 max' => 'macbook_pro_m3_max.jpg',
        'macbook pro m3 pro' => 'macbook_pro_m3_pro.jpg',
        'macbook pro m3' => 'macbook_pro_m3.jpg',
        'macbook air m3' => 'macbook_air_m3.jpg',
        'macbook air m2' => 'macbook_air_m2.jpg',
        'dell xps 15' => 'dell_xps_15.jpg',
        'thinkpad' => 'thinkpad_x1.jpg',
        'hp spectre' => 'hp_spectre.jpg',
        'asus rog' => 'asus_rog_g14.jpg',
        'asus zenbook' => 'asus_zenbook.jpg',
    ];
    foreach ($specific as $key => $file) {
        if (strpos($nom_lower, $key) !== false) {
            return '/techshop/public/assets/images/' . $file;
        }
    }
    $base = '/techshop/public/assets/images/';
    $marque_lower = strtolower($marque);
    $images_marque = [
        'apple' => 'apple_default.jpg',
        'samsung' => 'samsung_default.jpg',
        'dell' => 'dell_default.jpg',
        'lg' => 'lg_default.jpg',
        'sony' => 'sony_default.jpg',
        'google' => 'google_default.jpg',
        'xiaomi' => 'xiaomi_default.jpg',
        'lenovo' => 'lenovo_default.jpg',
        'hp' => 'hp_default.jpg',
        'asus' => 'asus_default.jpg',
    ];
    if (isset($images_marque[$marque_lower])) {
        return $base . $images_marque[$marque_lower];
    }
    return $base . 'default.jpg';
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
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

if ($produit) {
    $produit['image'] = getImageForProduct($produit['nom'], $produit['marque']);
    echo json_encode($produit);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Produit non trouvé']);
}
?>