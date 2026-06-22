<?php
session_start();
$page_title = "Valider commande";
include '../views/header.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}
?>

<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">📝 Valider ma commande</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Formulaire -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h3 class="text-xl font-bold mb-4">Adresse de livraison</h3>
            <form id="commandeForm">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Nom complet</label>
                    <input type="text" id="nom" required class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Téléphone</label>
                    <input type="tel" id="telephone" required class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Adresse complète</label>
                    <textarea id="adresse" rows="3" required class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Ville</label>
                    <input type="text" id="ville" required class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                </div>
                <button type="submit" class="w-full bg-[#1e3a8a] text-white py-3 rounded-xl hover:bg-[#1e40af] transition font-semibold">
                    <i class="fas fa-check-circle"></i> Confirmer la commande
                </button>
            </form>
        </div>
        
        <!-- Récapitulatif -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h3 class="text-xl font-bold mb-4">Récapitulatif</h3>
            <div id="recap" class="space-y-3">
                <div class="text-center py-10">
                    <div class="loader"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function getImageUrl(nom) {
    const nom_lower = nom.toLowerCase();
    
    const imageMap = {
        'iphone 15 pro max': 'iphone_15_pro_max.jpg',
        'iphone 15 pro': 'iphone_15_pro.jpg',
        'iphone 15 plus': 'iphone_15_plus.jpg',
        'iphone 15': 'iphone_15.jpg',
        'iphone 14 pro max': 'iphone_14_pro_max.jpg',
        'iphone 14 plus': 'iphone_14_plus.jpg',
        'iphone 14': 'iphone_14.jpg',
        'iphone se': 'iphone_se.jpg',
        'iphone 13 pro max': 'iphone_13_pro_max.jpg',
        'iphone 13': 'iphone_13.jpg',
        'samsung galaxy s24 ultra': 'samsung_s24_ultra.jpg',
        'samsung galaxy s24 plus': 'samsung_s24_plus.jpg',
        'samsung galaxy s24': 'samsung_s24.jpg',
        'samsung galaxy s23 ultra': 'samsung_s23_ultra.jpg',
        'samsung galaxy z fold': 'samsung_z_fold5.jpg',
        'samsung galaxy z flip': 'samsung_z_flip5.jpg',
        'samsung galaxy a55': 'samsung_a55.jpg',
        'samsung galaxy a35': 'samsung_a35.jpg',
        'samsung galaxy s23': 'samsung_s23.jpg',
        'samsung galaxy note20': 'samsung_note20.jpg',
        'macbook pro m3 max': 'macbook_pro_m3_max.jpg',
        'macbook pro m3 pro': 'macbook_pro_m3_pro.jpg',
        'macbook pro m3': 'macbook_pro_m3.jpg',
        'macbook air m3': 'macbook_air_m3.jpg',
        'macbook air m2': 'macbook_air_m2.jpg',
        'macbook pro m2': 'macbook_pro_m2.jpg',
        'macbook air m1': 'macbook_air_m1.jpg',
        'macbook pro 14': 'macbook_pro_14.jpg',
        'macbook pro 16': 'macbook_pro_16.jpg',
        'imac': 'imac_m3.jpg',
        'dell xps 15': 'dell_xps_15.jpg',
        'dell xps 13': 'dell_xps_13.jpg',
        'dell inspiron': 'dell_inspiron.jpg',
        'thinkpad': 'thinkpad_x1.jpg',
        'legion': 'lenovo_legion.jpg',
        'yoga': 'lenovo_yoga.jpg',
        'hp spectre': 'hp_spectre.jpg',
        'hp victus': 'hp_victus.jpg',
        'asus rog': 'asus_rog_g14.jpg',
        'asus zenbook': 'asus_zenbook.jpg',
        'réfrigérateur samsung': 'refrigerateur_samsung.jpg',
        'réfrigérateur lg': 'refrigerateur_lg.jpg',
        'micro-ondes samsung': 'micro_ondes_samsung.jpg',
        'micro-ondes lg': 'micro_ondes_lg.jpg',
        'lave-linge samsung': 'lave_linge_samsung.jpg',
        'lave-linge lg': 'lave_linge_lg.jpg',
        'nespresso': 'nespresso.jpg',
        'delonghi': 'delonghi.jpg',
        'philips': 'philips.jpg',
        'thermomix': 'thermomix.jpg',
        'kitchenaid': 'kitchenaid.jpg',
        'dyson v15': 'dyson_v15.jpg',
        'rowenta': 'rowenta.jpg',
        'samsung jet': 'samsung_jet.jpg',
        'roomba': 'roomba_i7.jpg'
    };
    
    for(let key in imageMap) {
        if(nom_lower.includes(key)) {
            return '/techshop/public/assets/images/' + imageMap[key];
        }
    }
    
    // Image par défaut
    return '/techshop/public/assets/images/iphone.jpg';
}

function chargerPanier() {
    fetch('/techshop/api/panier/afficher.php')
    .then(res => res.json())
    .then(data => {
        let total = 0;
        if(!data.length) {
            document.getElementById('recap').innerHTML = `
                <div class="text-center py-10">
                    <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Votre panier est vide</p>
                    <a href="catalogue.php" class="inline-block mt-4 bg-[#1e3a8a] text-white px-4 py-2 rounded-xl">Continuer mes achats</a>
                </div>
            `;
            return;
        }
        
        let html = data.map(item => {
            total += item.prix_unitaire * item.quantite;
            return `
                <div class="flex items-center gap-3 border-b pb-3">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="${getImageUrl(item.nom)}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm">${item.nom}</p>
                        <p class="text-xs text-gray-500">x${item.quantite}</p>
                    </div>
                    <span class="font-bold text-[#1e3a8a]">${(item.prix_unitaire * item.quantite).toLocaleString()} FCFA</span>
                </div>
            `;
        }).join('');
        
        html += `
            <div class="flex justify-between pt-3 font-bold text-lg border-t">
                <span>Total</span>
                <span class="text-[#1e3a8a]">${total.toLocaleString()} FCFA</span>
            </div>
        `;
        
        document.getElementById('recap').innerHTML = html;
    });
}

document.getElementById('commandeForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const adresse = document.getElementById('adresse').value + ', ' + document.getElementById('ville').value;
    
    const response = await fetch('/techshop/api/commandes/creer.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ adresse })
    });
    
    const data = await response.json();
    
    if(data.success) {
        Swal.fire({
            icon: 'success',
            title: 'Commande validée !',
            text: `Votre commande n°${data.numero} a été enregistrée`,
            confirmButtonText: 'Voir mes commandes'
        }).then(() => {
            window.location.href = 'historique.php';
        });
    } else {
        Swal.fire('Erreur', data.error || 'Une erreur est survenue', 'error');
    }
});

chargerPanier();
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