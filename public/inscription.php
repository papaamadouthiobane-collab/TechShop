<?php
session_start();
require_once '../config/database.php';

$error = '';
$success = '';

if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $password = $_POST['mot_de_passe'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if(empty($nom) || empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs obligatoires";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide";
    } elseif(strlen($password) < 4) {
        $error = "Le mot de passe doit contenir au moins 4 caractères";
    } elseif($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->fetch()) {
            $error = "Cet email est déjà utilisé";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, telephone) VALUES (?, ?, ?, ?)");
            if($stmt->execute([$nom, $email, $hashed, $telephone])) {
                $userId = $pdo->lastInsertId();
                $pdo->prepare("INSERT INTO paniers (utilisateur_id) VALUES (?)")->execute([$userId]);
                
                $_SESSION['user_id'] = $userId;
                $_SESSION['nom'] = $nom;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = 'client';
                
                $success = "Inscription réussie ! Redirection...";
                header("refresh:2;url=index.php");
            } else {
                $error = "Erreur lors de l'inscription";
            }
        }
    }
}

$page_title = "Inscription";
include '../views/header.php';
?>

<div class="max-w-md mx-auto bg-white rounded-2xl shadow-lg p-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-[#1e3a8a]">Créer un compte</h2>
    
    <?php if($error): ?>
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if($success): ?>
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nom complet <span class="text-red-500">*</span></label>
            <input type="text" name="nom" required class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" required class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Téléphone</label>
            <input type="tel" name="telephone" class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Mot de passe <span class="text-red-500">*</span></label>
            <input type="password" name="mot_de_passe" required class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Confirmer mot de passe <span class="text-red-500">*</span></label>
            <input type="password" name="confirm_password" required class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
        </div>
        <button type="submit" class="w-full bg-[#1e3a8a] text-white py-3 rounded-xl hover:bg-[#1e40af] transition font-semibold">
            S'inscrire
        </button>
    </form>
    <p class="text-center mt-4 text-gray-600">
        Déjà un compte ? <a href="connexion.php" class="text-[#1e3a8a] hover:underline">Se connecter</a>
    </p>
</div>

<?php include '../views/footer.php'; ?>