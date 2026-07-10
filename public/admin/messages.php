<?php
session_start();
$is_admin_page = true;

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /techshop/public/connexion.php');
    exit;
}

$page_title = "Admin - Messages";
include '../../views/header.php';
?>

<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">📩 Messages reçus</h1>
    
    <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left p-3">#</th>
                        <th class="text-left p-3">Nom</th>
                        <th class="text-left p-3">Email</th>
                        <th class="text-left p-3">Sujet</th>
                        <th class="text-left p-3">Message</th>
                        <th class="text-left p-3">Date</th>
                        <th class="text-left p-3">Statut</th>
                    </tr>
                </thead>
                <tbody id="messages-list">
                    <tr><td colspan="7" class="text-center py-10">Chargement...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
fetch('/techshop/api/admin/messages.php')
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById('messages-list');
        
        if(!data.length) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-10 text-gray-500">Aucun message</td></tr>';
            return;
        }
        
        tbody.innerHTML = data.map(m => {
            const nom = m.nom ?? '-';
            const email = m.email ?? '-';
            const sujet = m.sujet ?? '-';
            const message = m.message ?? (m.contenu ?? m.message_text ?? JSON.stringify(m));
            const createdAt = m.created_at ? new Date(m.created_at) : null;
            const dateStr = createdAt && !isNaN(createdAt.getTime())
                ? createdAt.toLocaleDateString('fr-FR')
                : '-';
            const lu = m.lu == 1 || m.lu === '1' || m.lu === true;

            return `
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">${m.id ?? '-'}</td>
                    <td class="p-3 font-medium">${nom}</td>
                    <td class="p-3">${email}</td>
                    <td class="p-3">${sujet}</td>
                    <td class="p-3 max-w-xs truncate">${message}</td>
                    <td class="p-3">${dateStr}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded-full text-xs ${lu ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                            ${lu ? 'Lu' : 'Non lu'}
                        </span>
                    </td>
                </tr>
            `;
        }).join('');
    })
    .catch(err => {
        document.getElementById('messages-list').innerHTML = '<tr><td colspan="7" class="text-center py-10 text-red-500">Erreur de chargement</td></tr>';
    });
</script>

<?php include '../../views/footer.php'; ?>