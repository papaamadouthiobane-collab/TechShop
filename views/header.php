<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>TechShop - <?php echo $page_title ?? 'Électronique & Tech'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f5f7fa; }
        :root { --primary: #1e3a8a; --primary-dark: #1e3a8a; --primary-light: #3b82f6; }
        
        /* Animations */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        .animate-fadeInDown { animation: fadeInDown 0.6s ease-out; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out; }
        .animate-slideInLeft { animation: slideInLeft 0.5s ease-out; }
        .float-animation { animation: float 4s ease-in-out infinite; }
        .pulse-animation { animation: pulse 2s ease-in-out infinite; }
        
        /* Navbar */
        .navbar { 
            background: #1e3a8a; 
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }
        .navbar-scrolled {
            background: rgba(30, 58, 138, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
            padding: 0.5rem 0;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #93c5fd, #60a5fa);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .nav-link:hover {
            color: #93c5fd !important;
        }
        
        /* Dropdown */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        .group:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        /* Product card */
        .product-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 40px -20px rgba(0,0,0,0.25);
        }
        
        /* Loader */
        .loader {
            width: 50px;
            height: 50px;
            border: 3px solid #e2e8f0;
            border-top: 3px solid #1e3a8a;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 40px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Hero */
        .hero-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e3a8a 50%, #1e40af 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Cart badge */
        .cart-badge {
            animation: pulse 1.5s infinite;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .desktop-only { display: none !important; }
            .mobile-menu-btn { display: block !important; }
        }
        @media (min-width: 769px) {
            .mobile-menu-btn { display: none !important; }
            .mobile-menu { display: none !important; }
        }
        
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 320px;
            height: 100%;
            background: #1e3a8a;
            z-index: 1000;
            transition: right 0.3s ease;
            padding: 20px;
            box-shadow: -5px 0 30px rgba(0,0,0,0.3);
        }
        .mobile-menu.open { right: 0; }
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }
        .overlay.show { display: block; }
        
        html { scroll-behavior: smooth; }
        img { max-width: 100%; height: auto; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top bar -->
    <div class="bg-[#0f172a] text-gray-300 text-sm py-2.5 desktop-only">
        <div class="container mx-auto px-6 flex justify-between items-center flex-wrap gap-2">
            <div class="flex items-center gap-6">
                <span><i class="fas fa-phone-alt mr-2 text-blue-300"></i> +221 76 732 37 98</span>
                <span><i class="fas fa-envelope mr-2 text-blue-300"></i> contact@techshop.sn</span>
                <span><i class="fas fa-map-marker-alt mr-2 text-blue-300"></i> Dakar, Sénégal</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-blue-300 transition"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-blue-300 transition"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-blue-300 transition"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-blue-300 transition"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>
    
    <!-- Navbar -->
    <nav class="navbar sticky top-0 z-50" id="navbar">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="/techshop/public/index.php" class="text-2xl font-bold flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-white rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fas fa-bolt text-[#1e3a8a] text-sm"></i>
                    </div>
                    <span class="text-white">TechShop</span>
                </a>
                
                <!-- Desktop menu -->
                <div class="desktop-only flex items-center gap-6">
                    <a href="/techshop/public/catalogue.php" class="nav-link text-gray-200 hover:text-blue-200 font-medium flex items-center gap-2">
                        <i class="fas fa-search text-sm"></i> Catalogue
                    </a>
                    <a href="/techshop/public/a-propos.php" class="nav-link text-gray-200 hover:text-blue-200 font-medium flex items-center gap-2">
                        <i class="fas fa-info-circle"></i> À propos
                    </a>
                    <a href="/techshop/public/contact.php" class="nav-link text-gray-200 hover:text-blue-200 font-medium flex items-center gap-2">
                        <i class="fas fa-envelope"></i> Contact
                    </a>
                    <a href="/techshop/public/panier.php" class="nav-link text-gray-200 hover:text-blue-200 font-medium flex items-center gap-2 relative">
                        <i class="fas fa-shopping-cart"></i> Panier
                        <span id="cart-count" class="cart-badge absolute -top-2 -right-4 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center text-[10px]">0</span>
                    </a>
                    <a href="/techshop/public/historique.php" class="nav-link text-gray-200 hover:text-blue-200 font-medium flex items-center gap-2">
                        <i class="fas fa-truck"></i> Commandes
                    </a>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <?php if($_SESSION['role'] == 'admin'): ?>
                            <a href="/techshop/public/admin/index.php" class="nav-link text-emerald-300 font-medium flex items-center gap-2">
                                <i class="fas fa-user-shield"></i> Admin
                            </a>
                        <?php endif; ?>
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-gray-200 hover:text-blue-200 transition">
                                <i class="fas fa-user-circle text-xl"></i>
                                <span><?php echo $_SESSION['nom'] ?? 'Client'; ?></span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-2xl dropdown-menu border border-gray-100">
                                <a href="/techshop/public/profil.php" class="block px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-t-xl"><i class="fas fa-user mr-2"></i> Mon profil</a>
                                <a href="/techshop/public/deconnexion.php" class="block px-4 py-3 text-red-600 hover:bg-gray-50 rounded-b-xl"><i class="fas fa-sign-out-alt mr-2"></i> Déconnexion</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/techshop/public/connexion.php" class="text-gray-200 hover:text-blue-200 font-medium flex items-center gap-2">
                            <i class="fas fa-lock"></i> Connexion
                        </a>
                        <a href="/techshop/public/inscription.php" class="bg-white text-[#1e3a8a] px-5 py-2 rounded-xl hover:bg-gray-100 transition flex items-center gap-2 font-semibold">
                            <i class="fas fa-user-plus"></i> Inscription
                        </a>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile menu button -->
                <button class="mobile-menu-btn text-white text-2xl" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>
    
    <!-- Mobile menu overlay -->
    <div class="overlay" id="overlay" onclick="toggleMobileMenu()"></div>
    
    <!-- Mobile menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="flex justify-end mb-6">
            <button onclick="toggleMobileMenu()" class="text-white text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="flex flex-col gap-4">
            <a href="/techshop/public/catalogue.php" class="text-gray-200 hover:text-blue-200 font-medium py-2" onclick="toggleMobileMenu()">
                <i class="fas fa-search mr-2"></i> Catalogue
            </a>
            <a href="/techshop/public/a-propos.php" class="text-gray-200 hover:text-blue-200 font-medium py-2" onclick="toggleMobileMenu()">
                <i class="fas fa-info-circle mr-2"></i> À propos
            </a>
            <a href="/techshop/public/contact.php" class="text-gray-200 hover:text-blue-200 font-medium py-2" onclick="toggleMobileMenu()">
                <i class="fas fa-envelope mr-2"></i> Contact
            </a>
            <a href="/techshop/public/panier.php" class="text-gray-200 hover:text-blue-200 font-medium py-2" onclick="toggleMobileMenu()">
                <i class="fas fa-shopping-cart mr-2"></i> Panier
                <span id="cart-count-mobile" class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-2">0</span>
            </a>
            <a href="/techshop/public/historique.php" class="text-gray-200 hover:text-blue-200 font-medium py-2" onclick="toggleMobileMenu()">
                <i class="fas fa-truck mr-2"></i> Commandes
            </a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php if($_SESSION['role'] == 'admin'): ?>
                    <a href="/techshop/public/admin/index.php" class="text-emerald-300 font-medium py-2" onclick="toggleMobileMenu()">
                        <i class="fas fa-user-shield mr-2"></i> Admin
                    </a>
                <?php endif; ?>
                <a href="/techshop/public/profil.php" class="text-gray-200 hover:text-blue-200 font-medium py-2" onclick="toggleMobileMenu()">
                    <i class="fas fa-user mr-2"></i> Mon profil
                </a>
                <a href="/techshop/public/deconnexion.php" class="text-red-300 font-medium py-2" onclick="toggleMobileMenu()">
                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                </a>
            <?php else: ?>
                <a href="/techshop/public/connexion.php" class="text-gray-200 hover:text-blue-200 font-medium py-2" onclick="toggleMobileMenu()">
                    <i class="fas fa-lock mr-2"></i> Connexion
                </a>
                <a href="/techshop/public/inscription.php" class="bg-white text-[#1e3a8a] px-5 py-2 rounded-xl text-center font-semibold" onclick="toggleMobileMenu()">
                    <i class="fas fa-user-plus mr-2"></i> Inscription
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <main class="container mx-auto px-6 py-8">
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('overlay');
            menu.classList.toggle('open');
            overlay.classList.toggle('show');
            document.body.style.overflow = menu.classList.contains('open') ? 'hidden' : '';
        }
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
        
        function updateCartCount() {
            fetch('/techshop/api/panier/afficher.php')
            .then(res => res.json())
            .then(data => {
                const count = Array.isArray(data) ? data.length : 0;
                const desktopCount = document.getElementById('cart-count');
                const mobileCount = document.getElementById('cart-count-mobile');
                if(desktopCount) desktopCount.textContent = count;
                if(mobileCount) mobileCount.textContent = count;
            })
            .catch(err => console.log(err));
        }
        
        function ajouterPanier(produitId) {
            fetch('/techshop/api/panier/ajouter.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ produit_id: produitId, quantite: 1 })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Ajouté !',
                        text: 'Produit ajouté au panier',
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    updateCartCount();
                } else if(data.error === 'Non authentifié') {
                    Swal.fire({
                        title: 'Connexion requise',
                        text: 'Veuillez vous connecter pour ajouter au panier',
                        icon: 'warning',
                        confirmButtonText: 'Se connecter',
                        confirmButtonColor: '#1e3a8a'
                    }).then(() => {
                        window.location.href = '/techshop/public/connexion.php';
                    });
                } else {
                    Swal.fire('Erreur', data.error || 'Une erreur est survenue', 'error');
                }
            })
            .catch(() => {
                Swal.fire('Erreur', 'Impossible de se connecter au serveur', 'error');
            });
        }
        
        updateCartCount();
    </script>
</body>
</html>