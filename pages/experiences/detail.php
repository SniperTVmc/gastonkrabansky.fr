<?php
require_once __DIR__ . "/../../includes/loaders/experiences.php";

$id = $_GET['id'] ?? '';
$type = $_GET['type'] ?? null;
$item = getParcoursItemById($id, $type);

// -------------------------------------------------------------------
// 1. CAS 404 : L'expérience n'existe pas ou l'ID est invalide
// -------------------------------------------------------------------
if (!$item) {
    http_response_code(404);
    $page_seo_key = 'experiences';
    $page_seo_custom = [
            'title' => 'Expérience introuvable — Gaston Krabansky',
            'description' => 'L\'expérience demandée n\'existe pas ou a été déplacée.',
            'robots' => 'noindex, follow'
    ];
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <?php include __DIR__ . "/../../includes/header.php"; ?>
    <body data-page="experiences">
    <?php include __DIR__ . "/../../includes/navbar.php"; ?>

    <main class="container" style="padding: 4rem 1rem; text-align: center;">
        <h1>404 — Expérience introuvable</h1>
        <p>L'expérience que vous recherchez n'existe pas ou son identifiant est incorrect.</p>
        <p><a href="/experiences" class="btn">Retourner à la liste des expériences</a></p>
    </main>

    <?php include __DIR__ . "/../../includes/footer.php"; ?>
    </body>
    </html>
    <?php
    exit;
}

// -------------------------------------------------------------------
// 2. CAS VALIDE : Définition dynamique des métadonnées SEO
// -------------------------------------------------------------------
$canonicalUrl = 'https://gastonkrabansky.fr/experiences/' . rawurlencode($type ?: $item['category']) . '/' . rawurlencode($id);

$page_seo_key = 'experiences';
$page_seo_custom = [
        'title' => ($item['title'] ?? 'Expérience') . ' — Gaston Krabansky',
        'description' => $item['short_description'] ?? $item['description'] ?? 'Découvrez les détails de l\'expérience ' . ($item['title'] ?? ''),
        'canonical' => $canonicalUrl,
        'og_image' => !empty($item['image']) ? $item['image'] : '/assets/images/profile/logo.webp',
        'og_type' => 'article',
        'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => $item['title'] ?? '',
                'description' => $item['short_description'] ?? $item['description'] ?? '',
                'author' => [
                        '@type' => 'Person',
                        'name' => 'Gaston Krabansky',
                        'url' => 'https://gastonkrabansky.fr'
                ]
        ]
];
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Head -->
    <?php include __DIR__ . "/../../includes/header.php"; ?>

    <body data-page="experiences">


        <!-- Navbar -->
        <?php include __DIR__ . "/../../includes/navbar.php"; ?>


        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Fil d'Ariane">
            <a href="/">Accueil</a> /
            <a href="/experiences">Expériences</a> /
            <span class="current"><?= htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
        </nav>


        <!-- Main Content -->
        <main class="experience-detail-container">
            <?= renderParcoursDetailHtml($item); ?>
        </main>


        <!-- Footer -->
        <?php include __DIR__ . "/../../includes/footer.php"; ?>

    </body>
</html>