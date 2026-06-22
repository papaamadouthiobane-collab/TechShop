<?php
session_start();
$page_title = "Catalogue";
include '../views/header.php';
?>

<div class="bg-gradient-to-r from-[#0f172a] to-[#1e293b] rounded-2xl text-white p-12 mb-10 text-center">
    <h1 class="text-4xl font-bold mb-3">📱 Notre catalogue</h1>
    <p class="text-lg text-gray-300">Découvrez plus de 100 produits high-tech et électroménager</p>
</div>

<div class="flex flex-col lg:flex-row gap-8">
    <!-- Sidebar filtres -->
    <div class="lg:w-80 flex-shrink-0">
        <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">
            <h3 class="font-bold text-lg mb-5 flex items-center gap-2"><i class="fas fa-filter text-[#1e3a8a]"></i> Filtres</h3>
            
            <div class="mb-5">
                <label class="block text-sm font-medium mb-2 text-gray-700">Marque</label>
                <select id="filtre_marque" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                    <option value="">Toutes les marques</option>
                    <option value="Apple">🍎 Apple</option>
                    <option value="Samsung">📱 Samsung</option>
                    <option value="Dell">💻 Dell</option>
                    <option value="Lenovo">💻 Lenovo</option>
                    <option value="HP">💻 HP</option>
                    <option value="Asus">💻 Asus</option>
                </select>
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-medium mb-2 text-gray-700">Catégorie</label>
                <select id="filtre_categorie" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                    <option value="">Toutes les catégories</option>
                    <option value="Smartphones">📱 Smartphones</option>
                    <option value="Ordinateurs">💻 Ordinateurs</option>
                    <option value="Tablettes">📱 Tablettes</option>
                    <option value="Électroménager">🧺 Électroménager</option>
                    <option value="Accessoires">🎧 Accessoires</option>
                    <option value="Gaming">🎮 Gaming</option>
                    

                </select>
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-medium mb-2 text-gray-700">Prix (FCFA)</label>
                <div class="flex gap-3">
                    <input type="number" id="prix_min" placeholder="Min" class="w-1/2 px-4 py-2.5 border border-gray-200 rounded-xl" value="0">
                    <input type="number" id="prix_max" placeholder="Max" class="w-1/2 px-4 py-2.5 border border-gray-200 rounded-xl" value="5000">
                </div>
            </div>
            
            <button id="appliquer_filtres" class="w-full bg-[#1e3a8a] text-white py-3 rounded-xl hover:bg-[#1e40af] transition font-medium">
                Appliquer les filtres
            </button>
            
            <button id="reset_filtres" class="w-full mt-3 bg-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-300 transition font-medium">
                Réinitialiser
            </button>
        </div>
    </div>
    
    <!-- Contenu principal -->
    <div class="flex-1">
        <div class="bg-white rounded-2xl shadow-md p-5 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="search" placeholder="Rechercher un produit..." 
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a]">
                    </div>
                </div>
                <select id="tri" class="px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] bg-white">
                    <option value="default">Trier par</option>
                    <option value="prix_asc">Prix croissant</option>
                    <option value="prix_desc">Prix décroissant</option>
                    <option value="nom_asc">Nom A-Z</option>
                </select>
            </div>
        </div>
        
        <div id="produits-count" class="text-gray-500 text-sm mb-4"></div>
        
        <div id="produits" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div class="col-span-full text-center py-10">
                <div class="loader"></div>
            </div>
        </div>
        
        <div id="pagination" class="flex justify-center mt-8 gap-2"></div>
    </div>
</div>

<script>
let currentPage = 1;

function chargerProduits() {
    const search = document.getElementById('search').value;
    const marque = document.getElementById('filtre_marque').value;
    const categorie = document.getElementById('filtre_categorie').value;
    const prix_min = document.getElementById('prix_min').value;
    const prix_max = document.getElementById('prix_max').value;
    const tri = document.getElementById('tri').value;
    
    let url = '/techshop/api/produits/index.php?page=' + currentPage + '&limit=12';
    if(search) url += '&search=' + encodeURIComponent(search);
    if(marque) url += '&marque=' + encodeURIComponent(marque);
    if(categorie) url += '&categorie=' + encodeURIComponent(categorie);
    if(prix_min && prix_min != 0) url += '&prix_min=' + prix_min;
    if(prix_max && prix_max != 5000) url += '&prix_max=' + prix_max;
    if(tri && tri !== 'default') url += '&tri=' + tri;
    
    document.getElementById('produits').innerHTML = '<div class="col-span-full text-center py-10"><div class="loader"></div></div>';
    
    fetch(url)
        .then(response => response.json())
        .then(response => {
            const container = document.getElementById('produits');
            const data = response.data || [];
            const total = response.total || 0;
            const totalPages = response.total_pages || 1;
            
            document.getElementById('produits-count').innerHTML = total > 0 ? total + ' produit(s) trouvé(s)' : '';
            
            if(!data.length) {
                container.innerHTML = '<div class="col-span-full text-center py-16"><i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i><p class="text-gray-500 text-lg">Aucun produit trouvé</p></div>';
                document.getElementById('pagination').innerHTML = '';
                return;
            }
            
            let html = '';
            data.forEach(function(p) {
                html += `
                    <div class="product-card bg-white rounded-2xl shadow-md overflow-hidden group cursor-pointer hover:shadow-xl transition-all duration-300" onclick="window.location.href='produit.php?id=${p.id}'">
                        <div class="h-48 overflow-hidden bg-gray-100 relative">
                            <img src="${p.image}" alt="${p.nom}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" onerror="this.src='/techshop/public/assets/images/iphone.jpg'">
                            <div class="absolute top-3 right-3 bg-yellow-400 text-gray-800 px-2 py-1 rounded-lg text-xs flex items-center gap-1">
                                <i class="fas fa-star text-xs"></i> ${p.rating || 4.5}
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="font-bold text-gray-800 text-sm">${p.nom.length > 35 ? p.nom.substring(0,35)+'...' : p.nom}</h3>
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">${p.marque}</span>
                            </div>
                            <p class="text-gray-500 text-xs mt-1 line-clamp-2">${(p.description_courte || p.description || '').substring(0, 70)}...</p>
                            <div class="flex items-center gap-1 my-2">
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                            </div>
                            <div class="mt-2">
                                <span class="text-xl font-bold text-[#1e3a8a]">${parseFloat(p.prix).toLocaleString()} FCFA</span>
                            </div>
                            <button onclick="event.stopPropagation(); ajouterPanier(${p.id})" class="mt-3 w-full bg-[#1e3a8a] text-white py-2 rounded-xl hover:bg-[#1e40af] transition text-sm flex items-center justify-center gap-2">
                                <i class="fas fa-cart-plus"></i> Ajouter
                            </button>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
            
            if(totalPages > 1) {
                let paginationHtml = '';
                for(let i = 1; i <= totalPages; i++) {
                    paginationHtml += `<button onclick="goToPage(${i})" class="w-10 h-10 rounded-xl ${i === currentPage ? 'bg-[#1e3a8a] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'} transition">${i}</button>`;
                }
                document.getElementById('pagination').innerHTML = paginationHtml;
            } else {
                document.getElementById('pagination').innerHTML = '';
            }
        })
        .catch(function(err) {
            console.error('Erreur:', err);
            document.getElementById('produits').innerHTML = '<div class="col-span-full text-center py-16 text-red-500"><i class="fas fa-exclamation-triangle text-6xl mb-4"></i><p>Erreur de chargement</p><button onclick="chargerProduits()" class="mt-4 bg-[#1e3a8a] text-white px-4 py-2 rounded-xl">Réessayer</button></div>';
        });
}

function goToPage(page) {
    currentPage = page;
    chargerProduits();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetFiltres() {
    document.getElementById('search').value = '';
    document.getElementById('filtre_marque').value = '';
    document.getElementById('filtre_categorie').value = '';
    document.getElementById('prix_min').value = '0';
    document.getElementById('prix_max').value = '5000';
    document.getElementById('tri').value = 'default';
    currentPage = 1;
    chargerProduits();
}

document.getElementById('appliquer_filtres').addEventListener('click', function() { currentPage = 1; chargerProduits(); });
document.getElementById('reset_filtres').addEventListener('click', resetFiltres);
document.getElementById('search').addEventListener('keypress', function(e) { if(e.key === 'Enter') { currentPage = 1; chargerProduits(); } });
document.getElementById('tri').addEventListener('change', function() { currentPage = 1; chargerProduits(); });

chargerProduits();
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 35px -12px rgba(0,0,0,0.2);
}
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