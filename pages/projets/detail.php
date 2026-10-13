<?php
    require_once __DIR__ . "/../../includes/loaders/projets.php";

    $id = $_GET['id'] ?? '';
    $projetItem = getProjetItemById($id);

    // -------------------------------------------------------------------
    // 1. CAS 404 : Le projet n'existe pas ou l'ID est invalide
    // -------------------------------------------------------------------
    if (!$projetItem) {
        http_response_code(404);
        $page_seo_key = 'projets';
        $page_seo_custom = [
                'title' => 'Projet introuvable — Gaston Krabansky',
                'description' => 'Le projet demandé n\'existe pas ou a été déplacé.',
                'robots' => 'noindex, follow'
        ];
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <?php include __DIR__ . "/../../includes/header.php"; ?>
            <body data-page="projets">
                <?php include __DIR__ . "/../../includes/navbar.php"; ?>

                <main class="container" style="padding: 4rem 1rem; text-align: center;">
                    <h1>404 — Projet introuvable</h1>
                    <p>Le projet que vous recherchez n'existe pas ou son identifiant est incorrect.</p>
                    <p><a href="/projets" class="btn">Retourner à la liste des projets</a></p>
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
    $page_seo_key = 'projets';
    $page_seo_custom = [
            'title' => ($projetItem['title'] ?? 'Projet') . ' — Gaston Krabansky',
            'description' => $projetItem['short_description'] ?? $projetItem['description'] ?? 'Découvrez les détails du projet ' . ($projetItem['title'] ?? ''),
            'canonical' => 'https://gastonkrabansky.fr/projets/' . rawurlencode($id),
            'og_image' => !empty($projetItem['image']) ? $projetItem['image'] : '/assets/images/profile/photo.webp',
            'og_type' => 'article',
            'schema' => [
                    '@context' => 'https://schema.org',
                    '@type' => 'SoftwareSourceCode',
                    'name' => $projetItem['title'] ?? '',
                    'description' => $projetItem['short_description'] ?? $projetItem['description'] ?? '',
                    'author' => [
                            '@type' => 'Person',
                            'name' => 'Gaston Krabansky',
                            'url' => 'https://gastonkrabansky.fr'
                    ],
                    'codeRepository' => $projetItem['github_url'] ?? $projetItem['repo'] ?? 'https://github.com/SniperTVmc/'
            ]
    ];
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Head -->
    <?php include __DIR__ . "/../../includes/header.php"; ?>

        <body data-page="projets">


        <!-- Navbar -->
        <?php include __DIR__ . "/../../includes/navbar.php"; ?>


        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Fil d'Ariane">
            <a href="/">Accueil</a> /
            <a href="/projets">Projets</a> /
            <span class="current"><?= htmlspecialchars($projetItem['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
        </nav>


        <!-- Page Content -->
        <main class="projet-detail-container">
            <?= renderProjetDetailHtml($projetItem); ?>
        </main>


        <!-- Footer -->
        <?php include __DIR__ . "/../../includes/footer.php"; ?>

    </body>
</html>