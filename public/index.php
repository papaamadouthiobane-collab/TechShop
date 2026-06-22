<?php
session_start();
$page_title = "Accueil";
include '../views/header.php';
?>

<!-- Hero Section -->
<section class="hero-section rounded-3xl text-white p-12 md:p-16 mb-16 text-center relative overflow-hidden">
    <div class="relative z-10 max-w-3xl mx-auto">
        <div class="float-animation">
            <i class="fas fa-bolt text-5xl mb-6 text-blue-300"></i>
        </div>
        <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fadeInUp">TechShop Sénégal</h1>
        <p class="text-lg md:text-xl mb-4 text-blue-100 animate-slideInLeft">La référence high-tech au Sénégal</p>
        <p class="text-base md:text-lg mb-8 text-blue-200">Livraison gratuite • Paiement sécurisé • Garantie 1 an</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="catalogue.php" class="inline-flex items-center gap-2 bg-white text-[#1e3a8a] px-6 md:px-8 py-3 md:py-4 rounded-xl font-semibold hover:bg-gray-100 transition transform hover:scale-105">
                <i class="fas fa-rocket"></i> Découvrir nos offres
            </a>
        </div>
    </div>
</section>

<!-- Services -->
<section class="mb-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="service-card bg-white p-6 rounded-2xl shadow-md text-center cursor-pointer transition">
            <div class="w-14 h-14 bg-[#1e3a8a] rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-truck-fast text-white text-xl"></i>
            </div>
            <h3 class="font-bold text-lg mb-1 text-gray-800">Livraison express</h3>
            <p class="text-gray-500 text-sm">Sous 24h à Dakar</p>
        </div>
        <div class="service-card bg-white p-6 rounded-2xl shadow-md text-center cursor-pointer transition">
            <div class="w-14 h-14 bg-[#1e3a8a] rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-shield-alt text-white text-xl"></i>
            </div>
            <h3 class="font-bold text-lg mb-1 text-gray-800">Paiement sécurisé</h3>
            <p class="text-gray-500 text-sm">Cryptage SSL 256 bits</p>
        </div>
        <div class="service-card bg-white p-6 rounded-2xl shadow-md text-center cursor-pointer transition">
            <div class="w-14 h-14 bg-[#1e3a8a] rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-headset text-white text-xl"></i>
            </div>
            <h3 class="font-bold text-lg mb-1 text-gray-800">Support 24/7</h3>
            <p class="text-gray-500 text-sm">Service client dédié</p>
        </div>
        <div class="service-card bg-white p-6 rounded-2xl shadow-md text-center cursor-pointer transition">
            <div class="w-14 h-14 bg-[#1e3a8a] rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-undo-alt text-white text-xl"></i>
            </div>
            <h3 class="font-bold text-lg mb-1 text-gray-800">Retour gratuit</h3>
            <p class="text-gray-500 text-sm">Sous 14 jours</p>
        </div>
    </div>
</section>

<!-- Produits populaires -->
<section class="mb-16">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-fire text-orange-500"></i> Produits populaires
            </h2>
            <p class="text-gray-500 mt-1 text-sm">Les produits les plus vendus du moment</p>
        </div>
        <a href="catalogue.php" class="text-[#1e3a8a] hover:text-[#1e40af] flex items-center gap-1 font-medium">
            Voir tout <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    <div id="produits" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="col-span-full"><div class="loader"></div></div>
    </div>
</section>

<!-- Bannières promotionnelles -->
<section class="mb-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-[#1e3a8a] rounded-2xl p-6 md:p-8 text-white relative overflow-hidden cursor-pointer">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full"></div>
            <i class="fas fa-percent text-4xl mb-3 relative z-10"></i>
            <h3 class="text-2xl md:text-3xl font-bold mb-2 relative z-10">-20% sur les Apple</h3>
            <p class="mb-4 relative z-10">Jusqu'à la fin du mois</p>
            <a href="catalogue.php?marque=Apple" class="inline-flex items-center gap-2 bg-white text-[#1e3a8a] px-5 py-2 rounded-xl font-semibold hover:bg-gray-100 transition relative z-10">
                Profiter <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="bg-[#1e40af] rounded-2xl p-6 md:p-8 text-white relative overflow-hidden cursor-pointer">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full"></div>
            <i class="fas fa-gift text-4xl mb-3 relative z-10"></i>
            <h3 class="text-2xl md:text-3xl font-bold mb-2 relative z-10">Livraison offerte</h3>
            <p class="mb-4 relative z-10">Dès 100 000 FCFA d'achat</p>
            <a href="catalogue.php" class="inline-flex items-center gap-2 bg-white text-[#1e3a8a] px-5 py-2 rounded-xl font-semibold hover:bg-gray-100 transition relative z-10">
                J'en profite <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Témoignages -->
<section class="mb-16">
    <div class="text-center mb-10">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Ce que nos clients disent</h2>
        <p class="text-gray-500 mt-2">Plus de 500 clients satisfaits</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition">
            <div class="flex gap-1 text-yellow-400 mb-3">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="text-gray-600 mb-4 text-sm">"Livraison rapide, produit conforme à la description. Je recommande vivement TechShop !"</p>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#1e3a8a] rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
                <div>
                    <span class="font-semibold block">Abdou D.</span>
                    <span class="text-xs text-gray-400">Dakar, Sénégal</span>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition">
            <div class="flex gap-1 text-yellow-400 mb-3">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="text-gray-600 mb-4 text-sm">"Site fiable, excellent service client. J'ai reçu mon MacBook en 2 jours !"</p>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#1e3a8a] rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
                <div>
                    <span class="font-semibold block">Mariama S.</span>
                    <span class="text-xs text-gray-400">Thiès, Sénégal</span>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition">
            <div class="flex gap-1 text-yellow-400 mb-3">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <p class="text-gray-600 mb-4 text-sm">"Très bon rapport qualité-prix, je suis satisfait de mon achat. Je reviendrai."</p>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#1e3a8a] rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
                <div>
                    <span class="font-semibold block">Ousmane F.</span>
                    <span class="text-xs text-gray-400">Saint-Louis, Sénégal</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistiques -->
<section class="mb-16">
    <div class="bg-[#0f172a] rounded-3xl p-6 md:p-10 text-white">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-2xl md:text-3xl font-bold text-blue-400">5000+</div>
                <p class="text-gray-400 text-sm mt-1">Clients satisfaits</p>
            </div>
            <div>
                <div class="text-2xl md:text-3xl font-bold text-blue-400">50+</div>
                <p class="text-gray-400 text-sm mt-1">Marques partenaires</p>
            </div>
            <div>
                <div class="text-2xl md:text-3xl font-bold text-blue-400">10000+</div>
                <p class="text-gray-400 text-sm mt-1">Produits vendus</p>
            </div>
            <div>
                <div class="text-2xl md:text-3xl font-bold text-blue-400">99%</div>
                <p class="text-gray-400 text-sm mt-1">Satisfaction client</p>
            </div>
        </div>
    </div>
</section>

<script>
fetch('/techshop/api/produits/index.php?limit=4')
    .then(res => res.json())
    .then(response => {
        const container = document.getElementById('produits');
        const data = response.data || [];
        if(!data.length) {
            container.innerHTML = '<div class="col-span-full text-center py-10 text-gray-500">Chargement...</div>';
            return;
        }
        container.innerHTML = data.map(p => `
            <div class="product-card bg-white rounded-2xl shadow-md overflow-hidden group cursor-pointer" onclick="window.location.href='produit.php?id=${p.id}'">
                <div class="h-44 overflow-hidden bg-gray-100 relative">
                    <img src="${p.image}" alt="${p.nom}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    ${p.prix_promo ? `<div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-0.5 rounded-lg text-xs font-bold">-${Math.round((1 - p.prix_promo/p.prix)*100)}%</div>` : ''}
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 text-sm md:text-base">${p.nom.length > 25 ? p.nom.substring(0,25)+'...' : p.nom}</h3>
                    <div class="flex items-center gap-1 my-1">
                        ${[...Array(5)].map(() => '<i class="fas fa-star text-yellow-400 text-xs"></i>').join('')}
                        <span class="text-xs text-gray-400 ml-1">(${p.avis})</span>
                    </div>
                    <div class="mt-2">
                        ${p.prix_promo ? 
                            `<span class="text-lg md:text-xl font-bold text-[#1e3a8a]">${parseFloat(p.prix_promo).toLocaleString()} FCFA</span>
                             <span class="text-xs text-gray-400 line-through ml-2">${parseFloat(p.prix).toLocaleString()} FCFA</span>` :
                            `<span class="text-lg md:text-xl font-bold text-[#1e3a8a]">${parseFloat(p.prix).toLocaleString()} FCFA</span>`
                        }
                    </div>
                    <button onclick="event.stopPropagation(); ajouterPanier(${p.id})" 
                            class="mt-3 w-full bg-[#1e3a8a] text-white py-2 rounded-xl hover:bg-[#1e40af] transition text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-cart-plus"></i> Ajouter
                    </button>
                </div>
            </div>
        `).join('');
    })
    .catch(err => console.error(err));
</script>

<?php include '../views/footer.php'; ?>