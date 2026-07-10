<?php
session_start();
$is_admin_page = true;

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /techshop/public/connexion.php');
    exit;
}

$page_title = "Admin - Utilisateurs";
include '../../views/header.php';
?>

<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">👥 Gestion des utilisateurs</h1>
    
    <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left p-3">ID</th>
                        <th class="text-left p-3">Nom</th>
                        <th class="text-left p-3">Email</th>
                        <th class="text-left p-3">Téléphone</th>
                        <th class="text-left p-3">Rôle</th>
                        <th class="text-left p-3">Action</th>
                    </tr>
                </thead>
                <tbody id="users-list">
                    <tr><td colspan="6" class="text-center py-10">Chargement...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
fetch('/techshop/api/utilisateurs/liste.php')
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById('users-list');
        
        if(!data.length) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-10 text-gray-500">Aucun utilisateur</td></tr>';
            return;
        }
        
        tbody.innerHTML = data.map(u => `
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">${u.id}</td>
                <td class="p-3 font-medium">${u.nom}</td>
                <td class="p-3">${u.email}</td>
                <td class="p-3">${u.telephone || '-'}</td>
                <td class="p-3">
                    <span class="px-2 py-1 rounded-full text-xs ${u.role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800'}">${u.role}</span>
                </td>
                <td class="p-3">
                    <select onchange="changerRole(${u.id}, this.value)" class="px-2 py-1 border rounded-lg text-xs">
                        <option value="client" ${u.role === 'client' ? 'selected' : ''}>Client</option>
                        <option value="admin" ${u.role === 'admin' ? 'selected' : ''}>Admin</option>
                    </select>
                </td>
            </tr>
        `).join('');
    });

function changerRole(userId, nouveauRole) {
    fetch('/techshop/api/utilisateurs/admin/role.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ user_id: userId, role: nouveauRole })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) location.reload();
        else alert('Erreur: ' + data.error);
    });
}
</script>

<?php include '../../views/footer.php'; ?>