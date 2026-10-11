<?php
    require_once __DIR__ . "/../../../includes/loaders/veilles.php";

    $id = $_GET['id'] ?? '';
    $veilleItem = getVeilleItemById($id);

    // -------------------------------------------------------------------
    // 1. CAS 404 : La veille n'existe pas ou l'ID est invalide
    // -------------------------------------------------------------------
    if (!$veilleItem) {
        http_response_code(404);
        $page_seo_key = 'veilles';
        $page_seo_custom = [
                'title' => 'Veille introuvable — Gaston Krabansky',
                'description' => 'La veille technologique demandée n\'existe pas ou a été déplacée.',
                'robots' => 'noindex, follow'
        ];
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <?php include __DIR__ . "/../../../includes/header.php"; ?>
            <body data-page="bts-sio">
                <?php include __DIR__ . "/../../../includes/navbar.php"; ?>

                <main class="container" style="padding: 4rem 1rem; text-align: center;">
                    <h1>404 — Veille introuvable</h1>
                    <p>La veille technologique que vous recherchez n'existe pas ou son identifiant est incorrect.</p>
                    <p><a href="/bts-sio/veilles" class="btn">Retourner à la liste des veilles</a></p>
                </main>

                <?php include __DIR__ . "/../../../includes/footer.php"; ?>
            </body>
        </html>
        <?php
        exit;
    }

    // -------------------------------------------------------------------
    // 2. CAS VALIDE : Définition dynamique des métadonnées SEO
    // -------------------------------------------------------------------
    $page_seo_key = 'veilles';
    $page_seo_custom = [
            'title' => ($veilleItem['title'] ?? 'Veille Technologique') . ' — Gaston Krabansky',
            'description' => $veilleItem['short_description'] ?? $veilleItem['description'] ?? 'Consultez cette veille technologique menée dans le cadre du BTS SIO par Gaston Krabansky.',
            'canonical' => 'https://gastonkrabansky.fr/bts-sio/veilles/detail?id=' . urlencode($id),
            'og_image' => !empty($veilleItem['image']) ? $veilleItem['image'] : '/assets/images/profile/logo.webp',
            'og_type' => 'article',
            'schema' => [
                    '@context' => 'https://schema.org',
                    '@type' => 'TechArticle',
                    'headline' => $veilleItem['title'] ?? '',
                    'description' => $veilleItem['short_description'] ?? $veilleItem['description'] ?? '',
                    'datePublished' => $veilleItem['date'] ?? null,
                    'author' => [
                            '@type' => 'Person',
                            'name' => 'Gaston Krabansky',
                            'url' => 'https://gastonkrabansky.fr'
                    ],
                    'publisher' => [
                            '@type' => 'Person',
                            'name' => 'Gaston Krabansky'
                    ]
            ]
    ];
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Head -->
    <?php include __DIR__ . "/../../../includes/header.php"; ?>

    <body data-page="bts-sio">


        <!-- Navbar -->
        <?php include __DIR__ . "/../../../includes/navbar.php"; ?>


        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Fil d'Ariane">
            <a href="/">Accueil</a> /
            <a href="/bts-sio">BTS SIO</a> /
            <a href="/bts-sio/veilles">Veilles</a> /
            <span class="current"><?= htmlspecialchars($veilleItem['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
        </nav>


        <!-- Main Content -->
        <main class="veille-detail-container">
            <?= renderVeilleDetailHtml($veilleItem); ?>
        </main>


        <!-- Footer -->
        <?php include __DIR__ . "/../../../includes/footer.php"; ?>

    </body>
</html>