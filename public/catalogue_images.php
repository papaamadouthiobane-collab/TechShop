<?php
session_start();
$page_title = "Images du catalogue";
include '../views/header.php';

$imagesDir = __DIR__ . '/assets/images';
$baseUrl = '/techshop/public/assets/images/';

$allowedExt = ['jpg','jpeg','png','gif','webp','avif'];

$files = [];
if (is_dir($imagesDir)) {
    $iterator = new DirectoryIterator($imagesDir);
    foreach ($iterator as $fileinfo) {
        if ($fileinfo->isDot()) continue;
        if (!$fileinfo->isFile()) continue;

        $name = $fileinfo->getFilename();
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt, true)) continue;

        $files[] = $name;
    }
}
     


sort($files, SORT_NATURAL | SORT_FLAG_CASE);
?>

<div class="bg-gradient-to-r from-[#0f172a] to-[#1e293b] rounded-2xl text-white p-12 mb-10 text-center">
    <h1 class="text-4xl font-bold mb-3">🖼️ Images produit (assets/images)</h1>
    <p class="text-lg text-gray-300">Affichage de toutes les images disponibles dans public/assets/images</p>
</div>

<div class="flex items-center justify-between mb-4">
    <div class="text-gray-600 text-sm">Total : <span class="font-semibold"><?php echo count($files); ?></span> image(s)</div>
</div>

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
    <?php if (!$files): ?>
        <div class="col-span-full bg-white rounded-2xl shadow-md p-6 text-center text-gray-500">
            Aucune image trouvée.
        </div>
    <?php else: ?>
        <?php foreach ($files as $filename): ?>
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="h-40 bg-gray-100 flex items-center justify-center">
                    <img
                        src="<?php echo $baseUrl . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8'); ?>"
                        alt="<?php echo htmlspecialchars($filename, ENT_QUOTES, 'UTF-8'); ?>"
                        class="w-full h-full object-cover"
                        loading="lazy"
                    >
                </div>
                <div class="p-3">
                    <div class="text-xs text-gray-700 truncate" title="<?php echo htmlspecialchars($filename, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($filename, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../views/footer.php'; ?>

