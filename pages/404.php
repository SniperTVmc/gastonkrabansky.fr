<?php
    $page_seo_key = '404';
?>
<!DOCTYPE html>
<html lang="fr">

    <!-- Header -->
    <?php include __DIR__ . "/../includes/header.php"; ?>

    <body data-page="404">


        <!-- Navbar -->
        <?php include __DIR__ . "/../includes/navbar.php"; ?>


        <!-- Error Page -->
        <main class="error-page">
            <h1><span>404</span></h1>
            <p>La page que vous recherchez est introuvable ou n’existe plus.</p>
            <a href="/" class="btn btn-fill">
                Retourner à l’accueil <i class="fas fa-arrow-right"></i>
            </a>
        </main>


        <!-- Footer -->
        <?php include __DIR__ . "/../includes/footer.php"; ?>

    </body>
</html>
