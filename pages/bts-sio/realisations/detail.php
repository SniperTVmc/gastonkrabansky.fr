<?php
    require_once __DIR__ . "/../../../includes/loaders/realisations.php";

    $id = $_GET['id'] ?? '';
    $realisationItem = getRealisationItemById($id);

    // -------------------------------------------------------------------
    // 1. CAS 404 : La réalisation n'existe pas ou l'ID est invalide
    // -------------------------------------------------------------------
    if (!$realisationItem) {
        http_response_code(404);
        $page_seo_key = 'bts_realisations';
        $page_seo_custom = [
                'title' => 'Réalisation introuvable — Gaston Krabansky',
                'description' => 'La réalisation demandée n\'existe pas ou a été déplacée.',
                'robots' => 'noindex, follow'
        ];
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <?php include __DIR__ . "/../../../includes/header.php"; ?>
            <body data-page="bts-sio">
                <?php include __DIR__ . "/../../../includes/navbar.php"; ?>

                <main class="container" style="padding: 4rem 1rem; text-align: center;">
                    <h1>404 — Réalisation introuvable</h1>
                    <p>La réalisation que vous recherchez n'existe pas ou son identifiant est incorrect.</p>
                    <p><a href="/bts-sio/realisations" class="btn">Retourner aux réalisations BTS SIO</a></p>
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
    $page_seo_key = 'bts_realisations';
    $page_seo_custom = [
            'title' => ($realisationItem['title'] ?? 'Réalisation BTS SIO') . ' — Gaston Krabansky',
            'description' => $realisationItem['short_description'] ?? $realisationItem['description'] ?? 'Découvrez cette réalisation professionnelle effectuée dans le cadre du BTS SIO SLAM par Gaston Krabansky.',
            'canonical' => 'https://gastonkrabansky.fr/bts-sio/realisations/' . rawurlencode($id),
            'og_image' => !empty($realisationItem['image']) ? $realisationItem['image'] : '/assets/images/profile/photo.webp',
            'og_type' => 'article',
            'schema' => [
                    '@context' => 'https://schema.org',
                    '@type' => 'CreativeWork',
                    'name' => $realisationItem['title'] ?? '',
                    'description' => $realisationItem['short_description'] ?? $realisationItem['description'] ?? '',
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
    <?php include __DIR__ . "/../../../includes/header.php"; ?>

    <body data-page="bts-sio">


        <!-- Navbar -->
        <?php include __DIR__ . "/../../../includes/navbar.php"; ?>


        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Fil d'Ariane">
            <a href="/">Accueil</a> /
            <a href="/bts-sio">BTS SIO</a> /
            <a href="/bts-sio/realisations">Réalisations & Compétences</a> /
            <span class="current"><?= htmlspecialchars($realisationItem['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
        </nav>


        <!-- Main Content -->
        <main class="realisation-detail-container">
            <?= renderRealisationsDetailHtml($realisationItem); ?>
        </main>


        <!-- Footer -->
        <?php include __DIR__ . "/../../../includes/footer.php"; ?>

    </body>
</html>