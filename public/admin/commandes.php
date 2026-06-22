<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /techshop/public/connexion.php');
    exit;
}

$page_title = "Admin - Commandes";
include '../../views/header.php';
?>

<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">🚚 Gestion des commandes</h1>
    
    <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left p-3">N° Commande</th>
                        <th class="text-left p-3">Client</th>
                        <th class="text-left p-3">Total</th>
                        <th class="text-left p-3">Statut</th>
                        <th class="text-left p-3">Date</th>
                        <th class="text-left p-3">Action</th>
                    </tr>
                </thead>
                <tbody id="commandes-list">
                    <tr><td colspan="6" class="text-center py-10">Chargement...</td></tr>
                </tbody>
            </table>
        </div>
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
    return `<span class="px-2 py-1 rounded-full text-xs ${colors[statut] || 'bg-gray-100'}">${labels[statut] || statut}</span>`;
}

fetch('/techshop/api/commandes/admin/liste.php')
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById('commandes-list');
        
        if(!data.length) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-10 text-gray-500">Aucune commande</td></tr>';
            return;
        }
        
        tbody.innerHTML = data.map(c => `
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 font-medium">${c.numero_commande}</td>
                <td class="p-3">${c.nom_client || 'Client'}</td>
                <td class="p-3">${parseFloat(c.total).toLocaleString()} FCFA</td>
                <td class="p-3">${getStatusBadge(c.statut)}</td>
                <td class="p-3">${new Date(c.created_at).toLocaleDateString('fr-FR')}</td>
                <td class="p-3">
                    <select onchange="changerStatut(${c.id}, this.value)" class="px-2 py-1 border rounded-lg text-xs">
                        <option value="en_attente" ${c.statut === 'en_attente' ? 'selected' : ''}>En attente</option>
                        <option value="validee" ${c.statut === 'validee' ? 'selected' : ''}>Validée</option>
                        <option value="expediee" ${c.statut === 'expediee' ? 'selected' : ''}>Expédiée</option>
                        <option value="livree" ${c.statut === 'livree' ? 'selected' : ''}>Livrée</option>
                        <option value="annulee" ${c.statut === 'annulee' ? 'selected' : ''}>Annulée</option>
                    </select>
                </td>
            </tr>
        `).join('');
    });

function changerStatut(commandeId, nouveauStatut) {
    fetch('/techshop/api/commandes/admin/statut.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ commande_id: commandeId, statut: nouveauStatut })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) location.reload();
        else alert('Erreur: ' + data.error);
    });
}
</script>

<?php include '../../views/footer.php'; ?>