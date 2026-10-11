<?php
    $page_seo_key = 'accueil';
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Head -->
    <?php include __DIR__ . "/../includes/header.php"; ?>

    <body data-page="accueil">


        <!-- Navigation -->
        <?php include __DIR__ . "/../includes/navbar.php"; ?>


        <!-- Hero -->
        <header id="hero">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1>Bonjour, je suis <span class="highlight">Gaston Krabansky</span></h1>
                <p>Étudiant en BTS SIO (option SLAM) / Développeur Java</p>
                <div class="hero-btns">
                    <a href="/projets" class="btn btn-fill">Voir mes projets <i class="fas fa-arrow-right"></i></a>
                    <a href="/assets/documents/cv/cv.pdf" download class="btn btn-outline">Télécharger mon CV <i class="fas fa-download"></i></a>
                </div>
            </div>
        </header>


        <!--About Me Section -->
        <section id="about" class="container">
            <h2 class="section-title">À propos de <span>moi</span></h2>
            <div class="about-grid">
                <div class="about-img">
                    <img src="/assets/images/profile/logo.webp"
                         alt="Portrait de Gaston Krabansky, développeur Java"
                         width="512" height="512" loading="eager">
                </div>
                <div class="about-text">
                    <p>
                        Je m'appelle Gaston Krabansky, j'ai 19 ans et je suis passionné par la programmation informatique.
                        Actuellement étudiant en <a href="/bts-sio" target="_blank">BTS SIO, option SLAM</a> au lycée Gaston Berger à Lille,
                        je me spécialise dans le développement backend / logiciel et l'administration système.<br><br>

                        Ma passion a commencé très jeune, portée notamment par mon intérêt pour le
                        jeu vidéo Minecraft. J'ai d'abord commencé à créer de petits scripts pour mon propre serveur, avant de
                        développer des plugins en Java que je partage aujourd'hui publiquement, à l'image de mon projet
                        <a href="/projets/detail?id=essentialsx-gui" target="_blank">EssentialsX GUI</a>, qui cumule plus de 30.000 téléchargements en octobre 2026.<br><br>

                        En dehors du code, les jeux vidéo et le cinéma constituent mes principaux centres d'intérêt.
                        J'ai un faible pour les œuvres dotées d'un scénario profond et immersif.
                        Qu'il s'agisse de blockbusters ou de créations indépendantes, certains récits m'ont profondément
                        marqué et continuent de m'inspirer au quotidien, tant sur le plan personnel que professionnel.
                    </p>

                    <div class="about-footer-row">
                        <span></span>
                        <span class="text-icons-inline has-tooltip-subtle" data-tooltip="Mes coups de cœur">
                            <i class="favorite-icon icon-tlou" aria-label="The Last of Us"></i>
                            <i class="favorite-icon icon-lis" aria-label="Life is Strange"></i>
                            <i class="favorite-icon icon-dbh" aria-label="Detroit: Become Human"></i>
                            <i class="favorite-icon icon-br-ba" aria-label="Breaking Bad"></i>
                            <i class="favorite-icon icon-bcs" aria-label="Better Call Saul"></i>
                        </span>
                    </div>

                    <div class="social-icons">
                        <a href="https://www.linkedin.com/in/gaston-krabansky/" target="_blank" aria-label="Profil LinkedIn de Gaston Krabansky"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://github.com/SniperTVmc/" target="_blank" aria-label="Profil GitHub de Gaston Krabansky"><i class="fab fa-github"></i></a>
                        <a href="mailto:gaston.krabansky@gmail.com" target="_blank" aria-label="E-Mail de Gaston Krabansky"><i class="fas fa-envelope"></i></a>
                        <a href="tel:+33648545504" target="_blank" aria-label="Téléphone de Gaston Krabansky"><i class="fas fa-phone"></i></a>
                    </div>
                </div>
            </div>
        </section>


        <!-- Discover the site Section -->
        <section class="bg-dark">
            <div class="container">
                <h2 class="section-title">Découvrir le <span>site</span></h2>
                <p class="section-lead">
                    Ce site a été conçu pour présenter mon parcours, mes compétences et mes projets.
                    Il est structuré de manière à faciliter la navigation et l'accès aux informations pertinentes.
                </p>
                <div class="overview-grid">
                    <a href="/competences" class="overview-card">
                        <i class="fas fa-code"></i>
                        <h3>Compétences</h3>
                        <p>Découvrez mes compétences techniques, mes outils et mes méthodes de travail.</p>
                    </a>
                    <a href="/experiences" class="overview-card">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Parcours</h3>
                        <p>Mon parcours scolaire et mes expériences professionnelles.</p>
                    </a>
                    <a href="/projets" class="overview-card">
                        <i class="fas fa-diagram-project"></i>
                        <h3>Projets</h3>
                        <p>Découvrez mes projets personnels et professionnels, ainsi que mes contributions open-source.</p>
                    </a>
                    <a href="/bts-sio" class="overview-card">
                        <i class="fas fa-school"></i>
                        <h3>BTS SIO</h3>
                        <p>Épreuve E5 : présentation, compétences acquises et veilles technologiques.</p>
                    </a>
                    <a href="/cv" class="overview-card">
                        <i class="fas fa-file-lines"></i>
                        <h3>Mon CV</h3>
                        <p>Consultez et téléchargez mon curriculum vitae au format PDF.</p>
                    </a>
                    <a href="/contact" class="overview-card">
                        <i class="fas fa-paper-plane"></i>
                        <h3>Contact</h3>
                        <p>Une question, une opportunité ? Envoyez-moi un message.</p>
                    </a>
                </div>
            </div>
        </section>


        <!-- Footer -->
        <?php include __DIR__ . "/../includes/footer.php"; ?>

    </body>
</html>
