    </main>
    
    <!-- Footer responsive -->
    <footer class="bg-gray-900 text-white mt-20">
        <!-- Newsletter -->
        <div class="border-b border-gray-800">
            <div class="container mx-auto px-6 py-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Abonnez-vous à notre newsletter</h3>
                        <p class="text-gray-400">Recevez nos offres exclusives et nouveautés</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <input type="email" placeholder="Votre email" class="flex-1 px-4 py-3 rounded-xl bg-gray-800 border border-gray-700 focus:outline-none focus:border-blue-500">
                        <button class="bg-blue-600 px-6 py-3 rounded-xl hover:bg-blue-700 transition whitespace-nowrap">
                            <i class="fas fa-paper-plane"></i> S'abonner
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Liens footer -->
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Colonne 1 - Brand -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-bolt text-2xl text-blue-500"></i>
                        <span class="text-2xl font-bold">TechShop</span>
                    </div>
                    <p class="text-gray-400 mb-4">Votre boutique en ligne pour produits électroniques et technologiques au Sénégal.</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <!-- Colonne 2 - Liens rapides -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Liens rapides</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/techshop/public/catalogue.php" class="hover:text-blue-400 transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Catalogue</a></li>
                        <li><a href="/techshop/public/a-propos.php" class="hover:text-blue-400 transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> À propos</a></li>
                        <li><a href="/techshop/public/contact.php" class="hover:text-blue-400 transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Contact</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Promotions</a></li>
                    </ul>
                </div>
                
                <!-- Colonne 3 - Aide & support -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Aide & support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-blue-400 transition flex items-center gap-2"><i class="fas fa-question-circle"></i> FAQ</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition flex items-center gap-2"><i class="fas fa-truck"></i> Livraison</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition flex items-center gap-2"><i class="fas fa-undo"></i> Retours</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition flex items-center gap-2"><i class="fas fa-shield-alt"></i> Garantie</a></li>
                    </ul>
                </div>
                
                <!-- Colonne 4 - Contact -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Contact</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-center gap-3"><i class="fas fa-map-marker-alt text-blue-500 w-5"></i> Dakar, Sénégal</li>
                        <li class="flex items-center gap-3"><i class="fas fa-phone-alt text-blue-500 w-5"></i> +221 76 732 37 98</li>
                        <li class="flex items-center gap-3"><i class="fas fa-envelope text-blue-500 w-5"></i> contact@techshop.sn</li>
                        <li class="flex items-center gap-3"><i class="fas fa-clock text-blue-500 w-5"></i> Lun-Sam: 9h - 19h</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-gray-800">
            <div class="container mx-auto px-6 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-gray-400 text-sm text-center">
                    <p>&copy; 2026 TechShop - Tous droits réservés</p>
                    <div class="flex flex-wrap gap-6 justify-center">
                        <a href="#" class="hover:text-blue-400 transition">Conditions générales</a>
                        <a href="#" class="hover:text-blue-400 transition">Confidentialité</a>
                        <a href="#" class="hover:text-blue-400 transition">Mentions légales</a>
                    </div>
                    <div class="flex gap-2">
                        <i class="fab fa-cc-visa text-2xl"></i>
                        <i class="fab fa-cc-mastercard text-2xl"></i>
                        <i class="fab fa-cc-amex text-2xl"></i>
                        <i class="fab fa-cc-paypal text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    /**
     * Ajoute un produit au panier
     * @param {number} produitId - L'ID du produit à ajouter
     */
    function ajouterPanier(produitId) {
        fetch('/techshop/api/panier/ajouter.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
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
                // Mettre à jour le compteur
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
        .catch(err => {
            console.error('Erreur:', err);
            Swal.fire('Erreur', 'Impossible de se connecter au serveur', 'error');
        });
    }

    /**
     * Met à jour le compteur du panier (badge)
     */
    function updateCartCount() {
        fetch('/techshop/api/panier/afficher.php')
        .then(res => res.json())
        .then(data => {
            const count = Array.isArray(data) ? data.length : 0;
            // Badge dans le header (desktop)
            const badgeDesktop = document.getElementById('cart-count');
            if(badgeDesktop) {
                badgeDesktop.textContent = count;
            }
            // Badge dans le menu mobile
            const badgeMobile = document.getElementById('cart-count-mobile');
            if(badgeMobile) {
                badgeMobile.textContent = count;
            }
        })
        .catch(err => console.log('Erreur compteur panier:', err));
    }

    // Initialiser le compteur au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();
    });
    </script>
</body>
</html>