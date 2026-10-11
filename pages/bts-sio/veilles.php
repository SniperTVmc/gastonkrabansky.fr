<?php
    require_once '../../includes/loaders/veilles.php';
    $page_seo_key = 'veilles';
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Head -->
    <?php include __DIR__ . "/../../includes/header.php"; ?>

    <body data-page="bts-sio">


        <!-- Navbar -->
        <?php include __DIR__ . "/../../includes/navbar.php"; ?>


        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="/">Accueil</a> / <a href="/bts-sio">BTS SIO</a> / <span class="current">Veilles technologiques</span>
        </div>


        <!-- Page Header -->
        <div class="page-header">
            <h1>Veilles <span>technologiques</span></h1>
            <p>Les veilles technologiques que j'ai réalisées au cours de ma formation.
                Elles complètent la <a href="/bts-sio">présentation du BTS SIO</a> et mes
                <a href="/bts-sio/realisations">réalisations</a>.
            </p>
        </div>


        <!-- Main Content -->
        <?= renderVeilleGridHtml(); ?>


        <!-- Footer -->
        <?php include __DIR__ . "/../../includes/footer.php"; ?>

    </body>
</html>
