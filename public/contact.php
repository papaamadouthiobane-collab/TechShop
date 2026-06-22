<?php
session_start();
$page_title = "Contact";
include '../views/header.php';

$message_envoye = false;
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sujet = trim($_POST['sujet'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if(empty($nom) || empty($email) || empty($sujet) || empty($message)) {
        $error = "Tous les champs sont obligatoires";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide";
    } else {
        $message_envoye = true;
    }
}
?>

<div class="max-w-5xl mx-auto">
    <!-- Hero -->
    <div class="bg-gradient-to-r from-[#0f172a] to-[#1e293b] rounded-3xl text-white p-16 mb-12 text-center relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-blue-500/10 rounded-full"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-purple-500/10 rounded-full"></div>
        <div class="relative z-10">
            <div class="float-animation">
                <i class="fas fa-envelope text-5xl text-blue-400 mb-4"></i>
            </div>
            <h1 class="text-5xl font-bold mb-4 animate-fadeInUp">Contactez-nous</h1>
            <p class="text-xl text-gray-300 animate-slideInLeft">Nous répondons dans les 24h</p>
        </div>
    </div>

    <!-- Infos contact -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition group">
            <div class="w-14 h-14 bg-[#1e3a8a] rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                <i class="fas fa-phone-alt text-white text-xl"></i>
            </div>
            <h3 class="font-bold text-lg">Téléphone</h3>
            <p class="text-gray-500">+221 76 732 37 98</p>
            <p class="text-xs text-gray-400 mt-1">Lun-Sam: 9h - 19h</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition group">
            <div class="w-14 h-14 bg-[#1e3a8a] rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                <i class="fas fa-envelope text-white text-xl"></i>
            </div>
            <h3 class="font-bold text-lg">Email</h3>
            <p class="text-gray-500">contact@techshop.sn</p>
            <p class="text-xs text-gray-400 mt-1">Réponse sous 24h</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition group">
            <div class="w-14 h-14 bg-[#1e3a8a] rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                <i class="fas fa-map-marker-alt text-white text-xl"></i>
            </div>
            <h3 class="font-bold text-lg">Adresse</h3>
            <p class="text-gray-500">Dakar, Sénégal</p>
            <p class="text-xs text-gray-400 mt-1">Venez nous rencontrer</p>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-1 h-8 bg-[#1e3a8a] rounded-full"></div>
            <h2 class="text-2xl font-bold text-gray-800">Envoyez-nous un message</h2>
        </div>

        <?php if($message_envoye): ?>
            <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-700 flex items-center gap-3 animate-fadeInUp">
                <i class="fas fa-check-circle text-xl"></i>
                <span>✅ Votre message a été envoyé ! Nous vous répondrons dans les plus brefs délais.</span>
            </div>
        <?php endif; ?>

        <?php if($error): ?>
            <div class="mb-6 p-4 rounded-xl bg-red-100 text-red-700 flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-xl"></i>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-user text-[#1e3a8a] mr-2"></i> Nom complet
                    </label>
                    <input type="text" name="nom" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] transition">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-envelope text-[#1e3a8a] mr-2"></i> Email
                    </label>
                    <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] transition">
                </div>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-tag text-[#1e3a8a] mr-2"></i> Sujet
                </label>
                <input type="text" name="sujet" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] transition">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-comment text-[#1e3a8a] mr-2"></i> Message
                </label>
                <textarea name="message" rows="5" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] transition resize-none"></textarea>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-[#1e3a8a] to-[#1e40af] text-white py-3 rounded-xl font-semibold hover:shadow-lg transition transform hover:scale-[1.02] flex items-center justify-center gap-2">
                <i class="fas fa-paper-plane"></i> Envoyer le message
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-center gap-6">
            <a href="#" class="text-gray-400 hover:text-[#1e3a8a] transition text-2xl"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-gray-400 hover:text-[#1e3a8a] transition text-2xl"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-gray-400 hover:text-[#1e3a8a] transition text-2xl"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-gray-400 hover:text-[#1e3a8a] transition text-2xl"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </div>
</div>

<?php include '../views/footer.php'; ?>