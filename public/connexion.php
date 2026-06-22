<?php
session_start();
require_once '../config/database.php';
require_once '../config/jwt.php';  // AJOUTE CETTE LIGNE

$error = '';

if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['mot_de_passe'] ?? '';
    
    if(empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            header('Location: index.php');
            exit;
        } else {
            $error = "Email ou mot de passe incorrect";
        }
    }
}

$page_title = "Connexion";
include '../views/header.php';
?>

<div class="max-w-md mx-auto bg-white rounded-2xl shadow-lg p-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-[#1e3a8a]">Connexion</h2>
    
    <?php if($error): ?>
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" required class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Mot de passe</label>
            <input type="password" name="mot_de_passe" required class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
        </div>
        <button type="submit" class="w-full bg-[#1e3a8a] text-white py-3 rounded-xl hover:bg-[#1e40af] transition font-semibold">
            Se connecter
        </button>
    </form>
    <p class="text-center mt-4 text-gray-600">
        Pas encore de compte ? <a href="inscription.php" class="text-[#1e3a8a] hover:underline">S'inscrire</a>
    </p>
</div>

<?php include '../views/footer.php'; ?>