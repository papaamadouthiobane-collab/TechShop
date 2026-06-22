<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /techshop/public/connexion.php');
    exit;
}

$page_title = "Admin - Produits";
include '../../views/header.php';
?>

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">📦 Gestion des produits</h1>
        <a href="produits_ajouter.php" class="bg-[#1e3a8a] text-white px-6 py-3 rounded-xl hover:bg-[#1e40af] transition">
            <i class="fas fa-plus mr-2"></i> Ajouter un produit
        </a>
    </div>
    
    <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left p-3">ID</th>
                        <th class="text-left p-3">Nom</th>
                        <th class="text-left p-3">Marque</th>
                        <th class="text-left p-3">Prix</th>
                        <th class="text-left p-3">Stock</th>
                        <th class="text-left p-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="produits-list">
                    <tr><td colspan="6" class="text-center py-10">Chargement...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
fetch('/techshop/api/produits/index.php?limit=100')
    .then(res => res.json())
    .then(response => {
        const data = response.data || [];
        const tbody = document.getElementById('produits-list');
        
        if(!data.length) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-10 text-gray-500">Aucun produit</td></tr>';
            return;
        }
        
        tbody.innerHTML = data.map(p => `
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">${p.id}</td>
                <td class="p-3 font-medium">${p.nom}</td>
                <td class="p-3">${p.marque}</td>
                <td class="p-3">${parseFloat(p.prix).toLocaleString()} FCFA</td>
                <td class="p-3 ${p.stock < 5 ? 'text-red-500 font-bold' : ''}">${p.stock}</td>
                <td class="p-3">
                    <a href="produits_modifier.php?id=${p.id}" class="bg-blue-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-blue-700">Modifier</a>
                    <button onclick="supprimerProduit(${p.id})" class="bg-red-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-red-700">Supprimer</button>
                </td>
            </tr>
        `).join('');
    });

function supprimerProduit(id) {
    if(!confirm('Voulez-vous vraiment supprimer ce produit ?')) return;
    
    fetch('/techshop/api/produits/supprimer.php', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) location.reload();
        else alert('Erreur: ' + data.error);
    });
}
</script>

<?php include '../../views/footer.php'; ?>