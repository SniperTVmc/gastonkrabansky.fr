<?php
    $page_seo_key = 'cv';
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Header -->
    <?php include __DIR__ . "/../includes/header.php"; ?>

    <body data-page="cv">


        <!-- Navbar -->
        <?php include __DIR__ . "/../includes/navbar.php"; ?>


        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="/">Accueil</a> / <span class="current">CV</span>
        </div>


        <!-- Page Header -->
        <div class="page-header">
            <h1>Mon <span>CV</span></h1>
            <p>Consultez mon curriculum vitae directement ci-dessous, ou téléchargez-le au format PDF.</p>
        </div>


        <!-- Page Content -->
        <section class="container">
            <div class="cv-wrapper">
                <div class="cv-preview">
                    <iframe src="/assets/documents/cv/cv.pdf" title="Aperçu du CV de Gaston Krabansky"></iframe>
                </div>
                <aside class="cv-side">
                    <h3>Télécharger</h3>
                    <p style="margin-bottom:20px; font-size:0.9rem;">Le fichier PDF ci-contre est un aperçu. Vous pouvez le télécharger pour le consulter hors-ligne ou l'imprimer.</p>
                    <a href="/assets/documents/cv/cv.pdf" download class="btn btn-fill"><i class="fas fa-download"></i> Télécharger le CV</a>
                    <a href="/assets/documents/cv/cv.pdf" target="_blank" class="btn btn-outline"><i class="fas fa-up-right-from-square"></i> Ouvrir dans un nouvel onglet</a>
                </aside>
            </div>
            <p style="text-align:center; margin-top:25px; font-size:0.85rem;">
                L'aperçu ci-dessus ne s'affiche pas sur tous les navigateurs mobiles : dans ce cas, utilisez le bouton de téléchargement.
            </p>
        </section>


        <!-- Footer -->
        <?php include __DIR__ . "/../includes/footer.php"; ?>

    </body>
</html>
