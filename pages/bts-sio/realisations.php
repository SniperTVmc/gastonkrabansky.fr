<?php
    require_once "../../includes/loaders/realisations.php";
    $page_seo_key = 'bts_realisations';
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Header -->
    <?php include __DIR__ . "/../../includes/header.php"; ?>

    <body data-page="bts-sio">


        <!-- Navbar -->
        <?php include __DIR__ . "/../../includes/navbar.php"; ?>


        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="/">Accueil</a> / <a href="/bts-sio">BTS SIO</a> / <span class="current">Réalisations & Compétences</span>
        </div>


        <!-- Page Header -->
        <div class="page-header">
            <h1>Réalisations <span>& Compétences</span></h1>
            <p>Les différentes compétences par réalisation faite que j'ai pu acquérir au cours de ma formation.</p>
        </div>


        <!-- Page Content -->
        <?= renderRealisationsPageHtml(); ?>

        <?php include __DIR__ . "/../../includes/footer.php"; ?>

    </body>
</html>