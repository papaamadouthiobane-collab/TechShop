<?php
session_start();
$page_title = "Détail produit";
include '../views/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
?>

<div class="max-w-5xl mx-auto" id="produit">
    <div class="loader"></div>
</div>

<script>
const productId = <?php echo $id; ?>;

function ajouterPanier(produitId) {
    fetch('/techshop/api/panier/ajouter.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ produit_id: produitId, quantite: 1 })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Ajouté !',
                text: 'Produit ajouté au panier',
                timer: 1500,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        } else if (data.error === 'Non authentifié') {
            Swal.fire({
                title: 'Connexion requise',
                text: 'Veuillez vous connecter pour ajouter au panier',
                icon: 'warning',
                confirmButtonText: 'Se connecter'
            }).then(() => {
                window.location.href = 'connexion.php';
            });
        } else {
            Swal.fire('Erreur', data.error || 'Une erreur est survenue', 'error');
        }
    })
    .catch(() => {
        Swal.fire('Erreur', 'Impossible de se connecter au serveur', 'error');
    });
}

fetch(`/techshop/api/produits/detail.php?id=${productId}`)
    .then(res => {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    })
    .then(p => {
        const container = document.getElementById('produit');
        if (p.error || !p.id) {
            container.innerHTML = `
                <div class="text-center py-16 bg-white rounded-2xl shadow-md">
                    <i class="fas fa-exclamation-triangle text-6xl text-red-500 mb-4"></i>
                    <p class="text-gray-500 text-lg">Produit non trouvé</p>
                    <a href="catalogue.php" class="inline-block mt-4 bg-[#1e3a8a] text-white px-6 py-3 rounded-xl hover:bg-[#1e40af] transition">
                        <i class="fas fa-arrow-left"></i> Retour au catalogue
                    </a>
                </div>
            `;
            return;
        }
        container.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <img src="${p.image}" alt="${p.nom}" class="w-full h-auto object-cover" onerror="this.onerror=null; this.src='/techshop/public/assets/images/iphone.jpg';">
                </div>
                <div>
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="bg-[#1e3a8a] text-white px-3 py-1 rounded-full text-xs font-medium">${p.marque}</span>
                        <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs">${p.categorie_nom || 'Produit'}</span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">${p.nom}</h1>
                    <p class="text-gray-600 leading-relaxed mb-6">${p.description}</p>
                    <div class="border-t border-b py-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">💰 Prix :</span>
                            <span class="text-3xl font-bold text-[#1e3a8a]">${parseFloat(p.prix).toLocaleString()} FCFA</span>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-gray-500">📦 Stock :</span>
                            <span class="${p.stock > 0 ? 'text-green-600' : 'text-red-600'} font-semibold">
                                ${p.stock > 0 ? `${p.stock} unités disponibles` : 'Rupture de stock'}
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="ajouterPanier(${p.id})" class="flex-1 bg-[#1e3a8a] text-white py-3 rounded-xl hover:bg-[#1e40af] transition flex items-center justify-center gap-2 font-semibold">
                            <i class="fas fa-cart-plus"></i> Ajouter au panier
                        </button>
                        <a href="catalogue.php" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-300 transition text-center font-semibold">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
            </div>
        `;
    })
    .catch(err => {
        console.error('Erreur:', err);
        document.getElementById('produit').innerHTML = `
            <div class="text-center py-16 bg-white rounded-2xl shadow-md">
                <i class="fas fa-wifi text-6xl text-red-500 mb-4"></i>
                <p class="text-gray-500 text-lg">Erreur de chargement</p>
                <button onclick="location.reload()" class="mt-4 bg-[#1e3a8a] text-white px-6 py-3 rounded-xl hover:bg-[#1e40af] transition">
                    <i class="fas fa-redo"></i> Réessayer
                </button>
            </div>
        `;
    });
</script>

<?php include '../views/footer.php'; ?>