<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . '/../../config/database.php';
// require_once __DIR__ . '/../_auth_admin.php';  // ← SUPPRIME ou COMMENTE cette ligne

function getProductImage($nom, $marque) {
    $nom_lower = strtolower($nom);
    $base_url = '/techshop/public/assets/images/';
    
    $mapping = [
        'iphone 15 pro max' => 'iphone_15_pro_max.jpg',
        'iphone 15 pro' => 'iphone_15_pro.jpg',
        'iphone 15 plus' => 'iphone_15_plus.jpg',
        'iphone 15' => 'iphone_15.jpg',
        'iphone 14 pro max' => 'iphone_14_pro_max.jpg',
        'iphone 14 plus' => 'iphone_14_plus.jpg',
        'iphone 14' => 'iphone_14.jpg',
        'iphone se' => 'iphone_se.jpg',
        'iphone 13 pro max' => 'iphone_13_pro_max.jpg',
        'iphone 13' => 'iphone_13.jpg',
        'samsung galaxy s24 ultra' => 'samsung_s24_ultra.jpg',
        'samsung galaxy s24 plus' => 'samsung_s24_plus.jpg',
        'samsung galaxy s24' => 'samsung_s24.jpg',
        'samsung galaxy s23 ultra' => 'samsung_s23_ultra.jpg',
        'samsung galaxy z fold' => 'samsung_z_fold5.jpg',
        'samsung galaxy z flip' => 'samsung_z_flip5.jpg',
        'samsung galaxy a55' => 'samsung_a55.jpg',
        'samsung galaxy a35' => 'samsung_a35.jpg',
        'samsung galaxy s23' => 'samsung_s23.jpg',
        'samsung galaxy note20' => 'samsung_note20.jpg',
        'macbook pro m3 max' => 'macbook_pro_m3_max.jpg',
        'macbook pro m3 pro' => 'macbook_pro_m3_pro.jpg',
        'macbook pro m3' => 'macbook_pro_m3.jpg',
        'macbook air m3' => 'macbook_air_m3.jpg',
        'macbook air m2' => 'macbook_air_m2.jpg',
        'macbook pro m2' => 'macbook_pro_m2.jpg',
        'macbook air m1' => 'macbook_air_m1.jpg',
        'macbook pro 14' => 'macbook_pro_14.jpg',
        'macbook pro 16' => 'macbook_pro_16.jpg',
        'imac' => 'imac_m3.jpg',
        'dell xps 15' => 'dell_xps_15.jpg',
        'dell xps 13' => 'dell_xps_13.jpg',
        'dell inspiron' => 'dell_inspiron.jpg',
        'thinkpad' => 'thinkpad_x1.jpg',
        'legion' => 'lenovo_legion.jpg',
        'yoga' => 'lenovo_yoga.jpg',
        'hp spectre' => 'hp_spectre.jpg',
        'hp victus' => 'hp_victus.jpg',
        'asus rog' => 'asus_rog_g14.jpg',
        'asus zenbook' => 'asus_zenbook.jpg',
        'réfrigérateur samsung' => 'refrigerateur_samsung.jpg',
        'réfrigérateur lg' => 'refrigerateur_lg.jpg',
        'réfrigérateur hisense' => 'refrigerateur_hisense.jpg',
        'réfrigérateur bosch' => 'refrigerateur_bosch.jpg',
        'réfrigérateur whirlpool' => 'refrigerateur_whirlpool.jpg',
        'micro-ondes samsung' => 'micro_ondes_samsung.jpg',
        'micro-ondes lg' => 'micro_ondes_lg.jpg',
        'micro-ondes whirlpool' => 'micro_ondes_whirlpool.jpg',
        'micro-ondes bosch' => 'micro_ondes_bosch.jpg',
        'micro-ondes sharp' => 'micro_ondes_sharp.jpg',
        'micro-ondes moulinex' => 'micro_ondes_moulinex.jpg',
        'lave-linge samsung' => 'lave_linge_samsung.jpg',
        'lave-linge lg' => 'lave_linge_lg.jpg',
        'lave-linge whirlpool' => 'lave_linge_whirlpool.jpg',
        'lave-linge bosch' => 'lave_linge_bosch.jpg',
        'lave-linge hisense' => 'lave_linge_hisense.jpg',
        'nespresso' => 'nespresso.jpg',
        'delonghi' => 'delonghi.jpg',
        'philips' => 'philips.jpg',
        'thermomix' => 'thermomix.jpg',
        'kitchenaid' => 'kitchenaid.jpg',
        'moulinex' => 'moulinex.jpg',
        'dyson v15' => 'dyson_v15.jpg',
        'rowenta' => 'rowenta.jpg',
        'samsung jet' => 'samsung_jet.jpg',
        'roomba' => 'roomba_i7.jpg'
    ];
    
    foreach($mapping as $key => $file) {
        if(strpos($nom_lower, $key) !== false) {
            return $base_url . $file;
        }
    }
    
    return $base_url . 'iphone.jpg';
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$marque = isset($_GET['marque']) ? $_GET['marque'] : '';
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';
$prix_min = isset($_GET['prix_min']) ? (float)$_GET['prix_min'] : 0;
$prix_max = isset($_GET['prix_max']) ? (float)$_GET['prix_max'] : 999999;
$tri = isset($_GET['tri']) ? $_GET['tri'] : 'default';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12;
$offset = ($page - 1) * $limit;

$sql = "SELECT p.*, c.nom as categorie_nom 
        FROM produits p 
        LEFT JOIN categories c ON p.categorie_id = c.id 
        WHERE 1=1";
$params = [];

// Filtre prix optionnel (sinon on n'exclut pas des produits qui sortent des bornes par défaut)
$sql .= " AND p.prix BETWEEN ? AND ?";
$params[] = $prix_min;
$params[] = $prix_max;


if(!empty($search)) {
    $sql .= " AND (p.nom LIKE ? OR p.description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if(!empty($marque)) {
    $sql .= " AND p.marque = ?";
    $params[] = $marque;
}
if(!empty($categorie)) {
    $sql .= " AND c.nom = ?";
    $params[] = $categorie;
}

if($tri === 'prix_asc') {
    $sql .= " ORDER BY p.prix ASC";
} elseif($tri === 'prix_desc') {
    $sql .= " ORDER BY p.prix DESC";
} elseif($tri === 'nom_asc') {
    $sql .= " ORDER BY p.nom ASC";
} else {
    $sql .= " ORDER BY p.id DESC";
}

$sqlCount = str_replace("SELECT p.*, c.nom as categorie_nom", "SELECT COUNT(*) as total", $sql);
$stmt = $pdo->prepare($sqlCount);
$stmt->execute($params);
$total = $stmt->fetch()['total'];

$sql .= " LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll();

foreach($produits as &$p) {
    $p['image'] = getProductImage($p['nom'], $p['marque']);
    $p['rating'] = 4.5;
    $p['avis'] = rand(10, 500);
    $p['description_courte'] = substr($p['description'], 0, 80);
}

$response = array(
    'data' => $produits,
    'total' => $total,
    'page' => $page,
    'limit' => $limit,
    'total_pages' => ceil($total / $limit)
);

echo json_encode($response);
?>