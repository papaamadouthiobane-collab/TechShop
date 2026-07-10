<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /techshop/public/connexion.php');
    exit;
}

$page_title = "Admin - Dashboard";
include '../../views/header.php';
?>

<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">📊 Dashboard Admin</h1>

    <!-- Statistiques cliquables -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" id="stats">
        <a href="produits.php" class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition transform hover:scale-105">
            <div class="text-4xl font-bold text-[#1e3a8a]" id="total-produits">-</div>
            <p class="text-gray-500 text-sm mt-1">📦 Produits</p>
            <p class="text-xs text-blue-500 mt-2">Cliquer pour gérer</p>
        </a>
        <a href="commandes.php" class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition transform hover:scale-105">
            <div class="text-4xl font-bold text-green-600" id="total-commandes">-</div>
            <p class="text-gray-500 text-sm mt-1">📋 Commandes</p>
            <p class="text-xs text-blue-500 mt-2">Cliquer pour gérer</p>
        </a>
        <a href="utilisateurs.php" class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition transform hover:scale-105">
            <div class="text-4xl font-bold text-purple-600" id="total-utilisateurs">-</div>
            <p class="text-gray-500 text-sm mt-1">👥 Utilisateurs</p>
            <p class="text-xs text-blue-500 mt-2">Cliquer pour gérer</p>
        </a>
        <a href="messages.php" class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition transform hover:scale-105">
            <div class="text-4xl font-bold text-orange-500" id="ca-total">-</div>
            <p class="text-gray-500 text-sm mt-1">💰 Chiffre d'affaires</p>
            <p class="text-xs text-blue-500 mt-2">Voir les messages</p>
        </a>
    </div>

    <!-- Messages non lus -->
    <div class="mb-8">
        <a href="messages.php" class="block bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-xl hover:bg-yellow-100 transition">
            <div class="flex items-center">
                <i class="fas fa-envelope text-yellow-600 text-xl mr-3"></i>
                <span class="font-medium text-yellow-800">Messages non lus :</span>
                <span id="messages-non-lus" class="ml-2 bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-sm font-bold">0</span>
                <span class="ml-4 text-sm text-blue-600 hover:underline">➜ Cliquer pour voir</span>
            </div>
        </a>
    </div>

    <!-- Navigation rapide -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="produits.php" class="bg-[#1e3a8a] text-white rounded-2xl shadow-md p-6 hover:bg-[#1e40af] transition text-center">
            <i class="fas fa-box text-4xl mb-3"></i>
            <h3 class="font-bold text-lg">Gestion des produits</h3>
            <p class="text-sm text-blue-100">Ajouter, modifier, supprimer</p>
        </a>
        <a href="commandes.php" class="bg-green-600 text-white rounded-2xl shadow-md p-6 hover:bg-green-700 transition text-center">
            <i class="fas fa-truck text-4xl mb-3"></i>
            <h3 class="font-bold text-lg">Gestion des commandes</h3>
            <p class="text-sm text-green-100">Voir et changer les statuts</p>
        </a>
        <a href="utilisateurs.php" class="bg-purple-600 text-white rounded-2xl shadow-md p-6 hover:bg-purple-700 transition text-center">
            <i class="fas fa-users text-4xl mb-3"></i>
            <h3 class="font-bold text-lg">Gestion des utilisateurs</h3>
            <p class="text-sm text-purple-100">Voir et gérer les rôles</p>
        </a>
    </div>
</div>

<script>
fetch('/techshop/api/admin/stats.php')
    .then(res => res.json())
    .then(data => {
        document.getElementById('total-produits').textContent = data.produits || 0;
        document.getElementById('total-commandes').textContent = data.commandes || 0;
        document.getElementById('total-utilisateurs').textContent = data.utilisateurs || 0;
        document.getElementById('ca-total').textContent = (data.ca || 0).toLocaleString() + ' FCFA';
        document.getElementById('messages-non-lus').textContent = data.messages_non_lus || 0;
    })
    .catch(err => {
        console.error('Erreur stats:', err);
    });
</script>

<?php include '../../views/footer.php'; ?>