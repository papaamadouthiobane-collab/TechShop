<?php
session_start();
$page_title = "À propos";
include '../views/header.php';
?>

<div class="max-w-6xl mx-auto">
    <!-- Hero -->
    <div class="bg-gradient-to-r from-[#0f172a] to-[#1e293b] rounded-3xl text-white p-16 mb-12 text-center relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-blue-500/10 rounded-full"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-purple-500/10 rounded-full"></div>
        <div class="relative z-10">
            <div class="float-animation">
                <i class="fas fa-bolt text-5xl text-blue-400 mb-4"></i>
            </div>
            <h1 class="text-5xl font-bold mb-4 animate-fadeInUp">À propos de TechShop</h1>
            <p class="text-xl text-gray-300 animate-slideInLeft">La référence high-tech au Sénégal</p>
        </div>
    </div>

    <!-- Notre histoire -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16 items-center">
        <div class="animate-fadeInUp">
            <span class="text-[#1e3a8a] font-semibold text-sm uppercase tracking-wider">Notre histoire</span>
            <h2 class="text-3xl font-bold text-gray-800 mt-2 mb-4">Une passion pour la technologie</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                TechShop est né en 2024 de la volonté de rendre la technologie accessible à tous au Sénégal. 
                Constatant le manque de plateformes fiables pour acheter des produits électroniques de qualité, 
                nous avons décidé de créer une boutique en ligne qui allie qualité, prix et service client.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Aujourd'hui, TechShop est devenu la référence pour les passionnés de technologie au Sénégal, 
                avec des milliers de clients satisfaits et des centaines de produits disponibles.
            </p>
        </div>
        <div class="grid grid-cols-2 gap-4 animate-slideInLeft">
            <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition">
                <div class="text-4xl font-bold text-[#1e3a8a]">5000+</div>
                <p class="text-gray-500 text-sm mt-1">Clients satisfaits</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition">
                <div class="text-4xl font-bold text-[#1e3a8a]">50+</div>
                <p class="text-gray-500 text-sm mt-1">Marques partenaires</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition">
                <div class="text-4xl font-bold text-[#1e3a8a]">10000+</div>
                <p class="text-gray-500 text-sm mt-1">Produits vendus</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition">
                <div class="text-4xl font-bold text-[#1e3a8a]">99%</div>
                <p class="text-gray-500 text-sm mt-1">Satisfaction client</p>
            </div>
        </div>
    </div>

    <!-- Nos valeurs -->
    <div class="mb-16">
        <div class="text-center mb-10">
            <span class="text-[#1e3a8a] font-semibold text-sm uppercase tracking-wider">Nos valeurs</span>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">Ce qui nous guide</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-xl transition group">
                <div class="w-16 h-16 bg-[#1e3a8a] rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Confiance</h3>
                <p class="text-gray-500 text-sm">Des produits authentiques et de qualité, garantis par nos partenaires officiels.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-xl transition group">
                <div class="w-16 h-16 bg-[#1e3a8a] rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Service</h3>
                <p class="text-gray-500 text-sm">Une équipe dédiée à votre écoute, disponible 7j/7 pour vous accompagner.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-xl transition group">
                <div class="w-16 h-16 bg-[#1e3a8a] rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                    <i class="fas fa-rocket text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Innovation</h3>
                <p class="text-gray-500 text-sm">Toujours à la pointe de la technologie pour vous offrir le meilleur.</p>
            </div>
        </div>
    </div>

    <!-- Équipe -->
    <div class="mb-16">
        <div class="text-center mb-10">
            <span class="text-[#1e3a8a] font-semibold text-sm uppercase tracking-wider">Notre équipe</span>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">Des passionnés à votre service</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition">
                <div class="w-24 h-24 bg-gradient-to-r from-[#1e3a8a] to-[#1e40af] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-white text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold">Ahmad Thiobane</h3>
                <p class="text-gray-500 text-sm">Fondateur & CEO</p>
                <div class="flex justify-center gap-3 mt-3">
                    <a href="#" class="text-gray-400 hover:text-[#1e3a8a] transition"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-gray-400 hover:text-[#1e3a8a] transition"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition">
                <div class="w-24 h-24 bg-gradient-to-r from-[#1e3a8a] to-[#1e40af] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-white text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold">Mariama Diallo</h3>
                <p class="text-gray-500 text-sm">Responsable Commercial</p>
                <div class="flex justify-center gap-3 mt-3">
                    <a href="#" class="text-gray-400 hover:text-[#1e3a8a] transition"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-gray-400 hover:text-[#1e3a8a] transition"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition">
                <div class="w-24 h-24 bg-gradient-to-r from-[#1e3a8a] to-[#1e40af] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-white text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold">Ousmane Diop</h3>
                <p class="text-gray-500 text-sm">Support Client</p>
                <div class="flex justify-center gap-3 mt-3">
                    <a href="#" class="text-gray-400 hover:text-[#1e3a8a] transition"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-gray-400 hover:text-[#1e3a8a] transition"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="bg-gradient-to-r from-[#1e3a8a] to-[#1e40af] rounded-3xl text-white p-12 text-center">
        <h3 class="text-3xl font-bold mb-3">Prêt à découvrir TechShop ?</h3>
        <p class="text-blue-100 mb-6">Rejoignez des milliers de clients satisfaits</p>
        <a href="/techshop/public/catalogue.php" class="inline-block bg-white text-[#1e3a8a] px-8 py-3 rounded-xl font-semibold hover:bg-gray-100 transition transform hover:scale-105">
            <i class="fas fa-shopping-bag mr-2"></i> Découvrir nos produits
        </a>
    </div>
</div>

<?php include '../views/footer.php'; ?>