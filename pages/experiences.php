<?php
    require_once("../includes/loaders/experiences.php");
    $page_seo_key = 'experiences';
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Header -->
    <?php include __DIR__ . "/../includes/header.php"; ?>

    <body data-page="experiences">


        <!-- Navbar -->
        <?php include __DIR__ . "/../includes/navbar.php"; ?>


        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="/">Accueil</a> / <span class="current">Expériences</span>
        </div>


        <!-- Page Header -->
        <div class="page-header">
            <h1>Mes <span>Expériences</span></h1>
            <p>
                Découvrez mon parcours scolaire, ainsi que mes expériences professionnelles,
                qui m'ont permis de développer mes <a href="/competences">compétences</a> et d'acquérir de nouvelles connaissances.
                Vous pouvez aussi consulter mon <a href="/cv">CV</a> pour une synthèse de mon parcours.
            </p>
        </div>


        <!-- Page Content -->
        <?= renderParcoursTimelineHtml(); ?>


        <!-- Footer -->
        <?php include __DIR__ . "/../includes/footer.php"; ?>

    </body>
</html>
