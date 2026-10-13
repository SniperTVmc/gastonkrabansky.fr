<?php
    $page_seo_key = 'politique_cookies';
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Header -->
    <?php include __DIR__ . "/../includes/header.php"; ?>

    <body data-page="politique-cookies">

        <!-- Navigation -->
        <?php include __DIR__ . "/../includes/navbar.php"; ?>


        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="/">Accueil</a> / <span class="current">Cookies</span>
        </div>


        <!-- Page Header -->
        <div class="page-header">
            <h1>Politique des <span>cookies</span></h1>
            <p>Informations sur les cookies et traceurs susceptibles d’être utilisés sur ce site.</p>
        </div>


        <!-- Page Content -->
        <main class="container detail-content">
            <section class="info-block">
                <h3>Qu’est-ce qu’un cookie ?</h3>
                <p>Un cookie est un petit fichier enregistré par votre navigateur. Il peut être nécessaire au fonctionnement du site ou servir à mémoriser une préférence et à produire des statistiques.</p>
            </section>

            <section class="info-block">
                <h3>Cookies analytiques du site</h3>
                <p>Le suivi interne peut utiliser les cookies suivants :</p>
                <ul>
                    <li><strong>analytics_session</strong> : identifie une session de navigation, conservé au maximum un an ;</li>
                    <li><strong>analytics_visitor</strong> : permet de distinguer un visiteur récurrent sans stocker directement son adresse IP, conservé au maximum deux ans ;</li>
                    <li><strong>analytics_consent</strong> : mémorise le choix relatif au suivi lorsqu’un mécanisme de consentement est disponible.</li>
                </ul>
                <p>Ces cookies sont activés par défaut et servent à mesurer l’audience, les parcours et les performances du site. Vous pouvez les refuser via le bandeau ou modifier votre choix depuis cette page. Le détail des données associées est présenté dans la <a href="/politique-de-confidentialite">politique de confidentialité</a>.</p>
            </section>

            <section class="info-block">
                <h3>Services externes</h3>
                <p>Le formulaire et certaines pages chargent des services tiers, notamment Web3Forms, hCaptcha, Google Fonts, Font Awesome et Google Docs Viewer. Ces services peuvent utiliser leurs propres cookies ou mécanismes similaires. Consultez leurs politiques respectives pour connaître leurs pratiques.</p>
            </section>

            <section class="info-block">
                <h3>Gérer les cookies</h3>
                <p>Vous pouvez accepter ou refuser le suivi depuis le bandeau, puis bloquer ou supprimer les cookies depuis les réglages de votre navigateur. Le refus du suivi n’empêche pas la consultation du site.</p>
                <p>Pour toute question concernant les traceurs du site, contactez <a href="mailto:contact@gastonkrabansky.fr">contact@gastonkrabansky.fr</a>.</p>
                <button type="button" class="btn btn-outline" data-cookie-reset>Modifier mon choix</button>
            </section>

            <p><small>Dernière mise à jour : 13 octobre 2026.</small></p>
        </main>


        <!-- Footer -->
        <?php include __DIR__ . "/../includes/footer.php"; ?>

    </body>
</html>
