<?php
session_start();
$page_title = "Mes commandes";
include '../views/header.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}
?>

<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">📦 Mes commandes</h1>
    
    <div id="commandes" class="space-y-4">
        <div class="loader"></div>
    </div>
</div>

<script>
function getStatusBadge(statut) {
    const colors = {
        'en_attente': 'bg-yellow-100 text-yellow-800',
        'validee': 'bg-blue-100 text-blue-800',
        'expediee': 'bg-purple-100 text-purple-800',
        'livree': 'bg-green-100 text-green-800',
        'annulee': 'bg-red-100 text-red-800'
    };
    const labels = {
        'en_attente': 'En attente',
        'validee': 'Validée',
        'expediee': 'Expédiée',
        'livree': 'Livrée',
        'annulee': 'Annulée'
    };
    return `<span class="px-3 py-1 rounded-full text-sm ${colors[statut] || 'bg-gray-100'}">${labels[statut] || statut}</span>`;
}

fetch('/techshop/api/commandes/historique.php')
.then(res => res.json())
.then(data => {
    const container = document.getElementById('commandes');
    
    if(!data.length) {
        container.innerHTML = `
            <div class="text-center py-16 bg-white rounded-2xl shadow-md">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Vous n'avez pas encore de commande</p>
                <a href="catalogue.php" class="inline-block mt-4 bg-[#1e3a8a] text-white px-6 py-3 rounded-xl">Commencer mes achats</a>
            </div>
        `;
        return;
    }
    
    container.innerHTML = data.map(c => `
        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4 pb-4 border-b">
                <div>
                    <span class="text-gray-500 text-sm">Commande</span>
                    <span class="font-bold">${c.numero_commande}</span>
                </div>
                <div>
                    <span class="text-gray-500 text-sm">Date</span>
                    <span class="font-medium ml-2">${new Date(c.created_at).toLocaleDateString('fr-FR')}</span>
                </div>
                <div>${getStatusBadge(c.statut)}</div>
                <div>
                    <span class="text-xl font-bold text-[#1e3a8a]">${parseFloat(c.total).toLocaleString()} FCFA</span>
                </div>
            </div>
            <div class="space-y-2">
                ${c.articles ? c.articles.map(a => `
                    <div class="flex justify-between items-center text-sm">
                        <span>${a.nom} x ${a.quantite}</span>
                        <span class="font-semibold">${(a.prix_unitaire * a.quantite).toLocaleString()} FCFA</span>
                    </div>
                `).join('') : '<p class="text-gray-500 text-sm">Détails non disponibles</p>'}
            </div>
            <div class="mt-3 text-sm text-gray-500">
                <i class="fas fa-map-marker-alt mr-1"></i> ${c.adresse_livraison}
            </div>
        </div>
    `).join('');
})
.catch(err => {
    document.getElementById('commandes').innerHTML = `
        <div class="text-center py-16 bg-white rounded-2xl shadow-md text-red-500">
            <i class="fas fa-exclamation-triangle text-6xl mb-4"></i>
            <p>Erreur de chargement</p>
        </div>
    `;
});
</script>

<style>
.loader {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #1e3a8a;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 20px auto;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<?php include '../views/footer.php'; ?>