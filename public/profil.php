<?php
session_start();
$page_title = "Mon profil";
include '../views/header.php';
?>

<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">👤 Mon profil</h1>
    
    <div class="bg-white rounded-2xl shadow-md p-6">
        <form id="profilForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 mb-2">Nom complet</label>
                    <input type="text" id="nom" class="w-full px-4 py-3 border rounded-xl bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" class="w-full px-4 py-3 border rounded-xl bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Téléphone</label>
                    <input type="tel" id="telephone" class="w-full px-4 py-3 border rounded-xl">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 mb-2">Adresse</label>
                    <textarea id="adresse" rows="3" class="w-full px-4 py-3 border rounded-xl"></textarea>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const token = localStorage.getItem('token');
if(!token) {
    window.location.href = 'connexion.php';
}

// Charger le profil
fetch('/techshop/api/utilisateurs/me.php', {
    headers: { 'Authorization': 'Bearer ' + token }
})
.then(res => res.json())
.then(data => {
    document.getElementById('nom').value = data.nom || '';
    document.getElementById('email').value = data.email || '';
    document.getElementById('telephone').value = data.telephone || '';
    document.getElementById('adresse').value = data.adresse || '';
});

document.getElementById('profilForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const response = await fetch('/techshop/api/utilisateurs/update.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({
            telephone: document.getElementById('telephone').value,
            adresse: document.getElementById('adresse').value
        })
    });
    
    const data = await response.json();
    if(data.success) {
        Swal.fire('Succès', 'Profil mis à jour', 'success');
    } else {
        Swal.fire('Erreur', data.error, 'error');
    }
});
</script>

<?php include '../views/footer.php'; ?>