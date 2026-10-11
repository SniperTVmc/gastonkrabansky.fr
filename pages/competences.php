<?php
    $page_seo_key = 'competences';
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Header -->
    <?php include __DIR__ . "/../includes/header.php"; ?>

    <body data-page="competences">


        <!-- Navbar -->
        <?php include __DIR__ . "/../includes/navbar.php"; ?>


        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="/">Accueil</a> / <span class="current">Compétences</span>
        </div>


        <!-- Page Header -->
        <div class="page-header">
            <h1>Mes <span>Compétences</span></h1>
            <p>
                Découvrez mes compétences techniques et professionnelles, acquises à travers mes études, mes projets personnels et mes expériences professionnelles.
            </p>
        </div>


        <!-- Page Content -->
        <!-- Page Content -->
        <section class="container">
            <div class="skills-grid-modern">

                <!-- Catégorie 1 : Programmation -->
                <div class="skill-category">
                    <div class="category-header">
                        <i class="fas fa-code"></i>
                        <h3>Programmation</h3>
                    </div>
                    <ul>
                        <li class="has-tooltip" data-tooltip="4 années d'expérience à travers différents projets personnels et scolaires.">
                            <strong>Java :</strong> POO avancée, Maven/Gradle, projets personnels <i class="fas fa-question info-icon"></i>
                        </li>
                        <li class="has-tooltip" data-tooltip="4 années d'expérience grâce à mes études.">
                            <strong>Python :</strong> Scripts, automatisation, projets scolaires et pro <i class="fas fa-question info-icon"></i>
                        </li>
                        <li class="has-tooltip" data-tooltip="1 année d'expérience grâce à mes études.">
                            <strong>PHP :</strong> Développement web dynamique, bases de données <i class="fas fa-question info-icon"></i>
                        </li>
                        <li class="has-tooltip" data-tooltip="Connaissances en HTML5, CSS3 et JavaScript, notamment via ce site.">
                            <strong>Web :</strong> HTML5, CSS3, JavaScript <i class="fas fa-question info-icon"></i>
                        </li>
                        <li><strong>Bases de données :</strong> SQL (Conception, gestion & requêtes)</li>
                    </ul>
                </div>

                <!-- Catégorie 2 : Systèmes & Réseaux -->
                <div class="skill-category">
                    <div class="category-header">
                        <i class="fas fa-server"></i>
                        <h3>Systèmes & Réseaux</h3>
                    </div>
                    <ul>
                        <li><strong>OS :</strong> Administration Linux (Debian) & Windows</li>
                        <li class="has-tooltip" data-tooltip="Déploiement et gestion de serveurs Web (Apache) et serveurs Mail (Poste.io).">
                            <strong>Services web :</strong> Apache2, Poste.io, phpMyAdmin <i class="fas fa-question info-icon"></i>
                        </li>
                        <li><strong>Bases de données :</strong> MariaDB & MySQL (installation, configuration)</li>
                        <li><strong>Sécurité :</strong> Gestion SSL/TLS (Certbot), pare-feu (UFW), bonnes pratiques</li>
                    </ul>
                </div>

                <!-- Catégorie 3 : Outils & Méthodes (Pleine largeur) -->
                <div class="skill-category skill-category-full">
                    <div class="category-header">
                        <i class="fas fa-tools"></i>
                        <h3>Outils, Méthodes & Environnements</h3>
                    </div>
                    <!-- Optionnel : si tu veux une liste en colonnes ou en ligne à l'intérieur de la grande carte -->
                    <ul class="skills-list-grid">
                        <li><strong>Versioning :</strong> Git & GitHub (workflows, Pull Requests, Actions)</li>
                        <li><strong>Infrastructure :</strong> Pterodactyl et Pelican</li>
                        <li><strong>Domaine :</strong> Cloudflare (DNS, sécurité)</li>
                        <li><strong>IDE :</strong> Suite JetBrains, VS Code, Visual Studio</li>
                        <li><strong>IA :</strong> Utilisation raisonnée et contrôle du code généré</li>
                    </ul>
                </div>

            </div>

            <div class="info-block" style="margin-top:40px; text-align:center;">
                <h3 style="justify-content:center;"><i class="fas fa-school"></i> Compétences validées dans le cadre du BTS SIO</h3>
                <p>
                    Pour plus d’informations sur les compétences acquises et validées dans le cadre de mon BTS SIO,
                    rendez-vous sur la page <a href="/bts-sio">BTS SIO</a> de la section dédiée.
                </p>
            </div>
        </section>


        <!-- Footer -->
        <?php include __DIR__ . "/../includes/footer.php"; ?>

    </body>
</html>
