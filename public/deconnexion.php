<?php
// Déconnexion (session PHP + nettoyage côté navigateur)
session_start();
?>

<script>
  // Important : ton projet utilise parfois la session PHP et parfois le token JWT.
  // Pour éviter de casser l’UI (ex: panier/commande) on nettoie uniquement les clés token
  // mais on ne force pas l’état “connecté/déconnecté” côté UI.
  try {
    const keys = [
      'token',
      'access_token',
      'jwt',
      'jwt_token',
      'authorization',
      'Authorization',
      'auth_token'
    ];

    keys.forEach(k => {
      try { localStorage.removeItem(k); } catch (e) {}
      try { sessionStorage.removeItem(k); } catch (e) {}
    });
  } catch (e) {}

  setTimeout(() => {
    window.location.href = '/techshop/public/index.php';
  }, 50);

  // Enforce la fermeture de session côté serveur via un refresh après logout
  // (utile si le cache navigateur conserve l’état JS)
  try { window.location.reload(); } catch(e) {}
</script>

<?php
session_destroy();
exit;
?>
