<?php
session_start();
$page_title = "Mon panier";
include '../views/header.php';
?>

<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">🛒 Mon panier</h1>
    
    <div id="panier-vide" class="hidden text-center py-16 bg-white rounded-2xl shadow-md">
        <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 text-lg">Votre panier est vide</p>
        <a href="catalogue.php" class="inline-block mt-4 bg-[#1e3a8a] text-white px-6 py-3 rounded-xl hover:bg-[#1e40af] transition">
            <i class="fas fa-shop"></i> Continuer mes achats
        </a>
    </div>
    
    <div id="panier-contenu" class="hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div id="articles" class="space-y-4"></div>
            </div>
            <div>
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">
                    <h3 class="text-xl font-bold mb-4">Récapitulatif</h3>
                    <div class="space-y-3 border-b pb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sous-total</span>
                            <span id="sous-total" class="font-semibold">0 FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Livraison</span>
                            <span class="font-semibold text-green-600">Gratuite</span>
                        </div>
                    </div>
                    <div class="flex justify-between mt-4 text-xl font-bold">
                        <span>Total</span>
                        <span id="total" class="text-[#1e3a8a]">0 FCFA</span>
                    </div>
                    <button id="valider-commande" class="w-full mt-6 bg-[#1e3a8a] text-white py-3 rounded-xl hover:bg-[#1e40af] transition">
                        <i class="fas fa-check"></i> Valider la commande
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function getImageUrl(item) {
    const nom = (item.nom || '').toLowerCase();
    
    const imageMap = {
        'iphone 15 pro max': 'iphone_15_pro_max.jpg',
        'iphone 15 pro': 'iphone_15_pro.jpg',
        'iphone 15 plus': 'iphone_15_plus.jpg',
        'iphone 15': 'iphone_15.jpg',
        'iphone 14 pro max': 'iphone_14_pro_max.jpg',
        'iphone 14 plus': 'iphone_14_plus.jpg',
        'iphone 14': 'iphone_14.jpg',
        'iphone se': 'iphone_se.jpg',
        'samsung galaxy s24 ultra': 'samsung_s24_ultra.jpg',
        'samsung galaxy s24 plus': 'samsung_s24_plus.jpg',
        'samsung galaxy s24': 'samsung_s24.jpg',
        'samsung galaxy s23 ultra': 'samsung_s23_ultra.jpg',
        'samsung galaxy z fold': 'samsung_z_fold5.jpg',
        'samsung galaxy z flip': 'samsung_z_flip5.jpg',
        'samsung galaxy a55': 'samsung_a55.jpg',
        'samsung galaxy a35': 'samsung_a35.jpg',
        'macbook pro m3 max': 'macbook_pro_m3_max.jpg',
        'macbook pro m3 pro': 'macbook_pro_m3_pro.jpg',
        'macbook pro m3': 'macbook_pro_m3.jpg',
        'macbook air m3': 'macbook_air_m3.jpg',
        'macbook air m2': 'macbook_air_m2.jpg',
        'macbook pro m2': 'macbook_pro_m2.jpg',
        'macbook air m1': 'macbook_air_m1.jpg',
        'dell xps 15': 'dell_xps_15.jpg',
        'dell xps 13': 'dell_xps_13.jpg',
        'thinkpad': 'thinkpad_x1.jpg',
        'legion': 'lenovo_legion.jpg',
        'hp spectre': 'hp_spectre.jpg',
        'hp victus': 'hp_victus.jpg',
        'asus rog': 'asus_rog_g14.jpg',
        'asus zenbook': 'asus_zenbook.jpg'
    };
    
    for(let key in imageMap) {
        if(nom.includes(key)) {
            return '/techshop/public/assets/images/' + imageMap[key];
        }
    }
    
    if(item.image_url && item.image_url !== 'null' && item.image_url !== '') {
        if(item.image_url.startsWith('/')) return item.image_url;
        return '/techshop/public' + item.image_url;
    }
    
    return '/techshop/public/assets/images/iphone.jpg';
}

function chargerPanier() {
fetch('/techshop/api/panier/afficher.php')
    .then(res => res.json())
    .then(data => {
        if(!data.length) {
            document.getElementById('panier-vide').classList.remove('hidden');
            document.getElementById('panier-contenu').classList.add('hidden');
            return;
        }
        
        document.getElementById('panier-vide').classList.add('hidden');
        document.getElementById('panier-contenu').classList.remove('hidden');
        
        let total = 0;
        const articlesHtml = data.map(item => {
            total += (parseFloat(item.prix_unitaire) || 0) * (parseInt(item.quantite, 10) || 0);
            const imageUrl = getImageUrl(item);
            return `
                <div class="bg-white rounded-2xl shadow-md p-4 flex flex-col sm:flex-row gap-4 items-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0">
                        <img src="${imageUrl}" alt="${item.nom}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        <h4 class="font-bold text-gray-800">${item.nom}</h4>
                        <p class="text-[#1e3a8a] font-bold">${parseFloat(item.prix_unitaire).toLocaleString()} FCFA</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button onclick="modifierQuantite(${item.produit_id}, ${item.quantite - 1})" class="w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300 transition">-</button>
                        <span id="qty-${item.produit_id}" class="w-8 text-center font-semibold">${item.quantite}</span>
                        <button onclick="modifierQuantite(${item.produit_id}, ${item.quantite + 1})" class="w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300 transition">+</button>
                    </div>
                    <button onclick="supprimerArticle(${item.produit_id})" class="text-red-500 hover:text-red-700 transition">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        }).join('');
        
        document.getElementById('articles').innerHTML = articlesHtml;
        document.getElementById('sous-total').innerHTML = total.toLocaleString() + ' FCFA';
        document.getElementById('total').innerHTML = total.toLocaleString() + ' FCFA';
    })
    .catch(err => console.error('Erreur panier:', err));
}

function modifierQuantite(produitId, nouvelleQuantite) {
    if(nouvelleQuantite <= 0) {
        supprimerArticle(produitId);
        return;
    }
    
    fetch('/techshop/api/panier/modifier.php', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ produit_id: produitId, quantite: nouvelleQuantite })
    })
    .then(() => chargerPanier());
}

function supprimerArticle(produitId) {
    fetch('/techshop/api/panier/supprimer.php', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ produit_id: produitId })
    })
    .then(() => chargerPanier());
}

document.getElementById('valider-commande').addEventListener('click', () => {
    window.location.href = 'commande.php';
});

chargerPanier();
</script>

<?php include '../views/footer.php'; ?>