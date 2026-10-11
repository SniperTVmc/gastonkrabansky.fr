<?php
    require_once("../includes/loaders/projets.php");
    $page_seo_key = 'projets';
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Header -->
    <?php include __DIR__ . "/../includes/header.php"; ?>

    <body data-page="projets">


        <!-- Navbar -->
        <?php include __DIR__ . "/../includes/navbar.php"; ?>


        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="/">Accueil</a> / <span class="current">Projets</span>
        </div>


        <!-- Page Header -->
        <div class="page-header">
            <h1>Mes <span>Projets</span></h1>
            <p>
                Découvrez mes différents projets réalisés dans un cadre professionnel ou personnel.
                Chaque projet est accompagné d'une description détaillée, des technologies utilisées et des liens vers les dépôts ou les démonstrations en ligne.
            </p>
        </div>


        <!-- Page Content -->
        <?= renderProjetsGridHtml(); ?>


        <!-- Footer -->
        <?php include __DIR__ . "/../includes/footer.php"; ?>

    </body>
</html>
