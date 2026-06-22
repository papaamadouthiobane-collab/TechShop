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
    
    <!-- Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" id="stats">
        <div class="bg-white rounded-2xl shadow-md p-6 text-center">
            <div class="text-4xl font-bold text-[#1e3a8a]" id="total-produits">-</div>
            <p class="text-gray-500 text-sm mt-1">Produits</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 text-center">
            <div class="text-4xl font-bold text-green-600" id="total-commandes">-</div>
            <p class="text-gray-500 text-sm mt-1">Commandes</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 text-center">
            <div class="text-4xl font-bold text-purple-600" id="total-utilisateurs">-</div>
            <p class="text-gray-500 text-sm mt-1">Utilisateurs</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 text-center">
            <div class="text-4xl font-bold text-orange-500" id="ca-total">-</div>
            <p class="text-gray-500 text-sm mt-1">Chiffre d'affaires</p>
        </div>
    </div>
    
    <!-- Navigation rapide -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="produits.php" class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition text-center">
            <i class="fas fa-box text-4xl text-[#1e3a8a] mb-3"></i>
            <h3 class="font-bold text-lg">Gestion des produits</h3>
            <p class="text-gray-500 text-sm">Ajouter, modifier, supprimer</p>
        </a>
        <a href="commandes.php" class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition text-center">
            <i class="fas fa-truck text-4xl text-green-600 mb-3"></i>
            <h3 class="font-bold text-lg">Gestion des commandes</h3>
            <p class="text-gray-500 text-sm">Voir et changer les statuts</p>
        </a>
        <a href="utilisateurs.php" class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition text-center">
            <i class="fas fa-users text-4xl text-purple-600 mb-3"></i>
            <h3 class="font-bold text-lg">Gestion des utilisateurs</h3>
            <p class="text-gray-500 text-sm">Voir et gérer les rôles</p>
        </a>
    </div>
</div>

<script>
// Charger les statistiques
fetch('/techshop/api/admin/stats.php')
    .then(res => res.json())
    .then(data => {
        document.getElementById('total-produits').textContent = data.produits || 0;
        document.getElementById('total-commandes').textContent = data.commandes || 0;
        document.getElementById('total-utilisateurs').textContent = data.utilisateurs || 0;
        document.getElementById('ca-total').textContent = (data.ca || 0).toLocaleString() + ' FCFA';
    });
</script>

<?php include '../../views/footer.php'; ?>