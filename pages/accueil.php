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
                        <a href="/projets/essentialsx-gui" target="_blank">EssentialsX GUI</a>, qui cumule plus de 30.000 téléchargements en octobre 2026.<br><br>

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
                        <a href="mailto:contact@gastonkrabansky.fr" target="_blank" aria-label="E-Mail de Gaston Krabansky"><i class="fas fa-envelope"></i></a>
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


        <!-- Featured Project Section : EssentialsX-GUI -->
        <section id="featured-project" class="container">
            <h2 class="section-title">Mon principal <span>Projet</span></h2>
            <p class="section-lead">
                Découvrez mon projet open-source <b>EssentialsX-GUI</b>, un plugin Minecraft qui simplifie la gestion des serveurs Spigot/Paper grâce à des interfaces graphiques intuitives.
            </p>

            <div class="featured-project-card-landscape">
                <!-- En-tête de la carte : Titre & Badges -->
                <div class="featured-header-row">
                    <div>
                        <h3>EssentialsX-GUI</h3>
                        <p class="featured-subtitle">Plugin Minecraft open-source développé en Java</p>
                    </div>
                    <div class="featured-badges">
                        <span class="tech-tag">Java</span>
                        <span class="tech-tag">Spigot API</span>
                        <span class="tech-tag">Gradle</span>
                        <span class="stat-tag">+32 000 téléchargements</span>
                    </div>
                </div>

                <!-- Aperçu visuel en format paysage (1920x1080 mis en valeur) -->
                <div class="featured-image-landscape">
                    <img src="/assets/images/projects/essentialsx-gui.webp"
                         alt="Aperçu du plugin EssentialsX-GUI"
                         width="1920" height="1080" loading="lazy">
                </div>

                <!-- Contenu en grille sous l'image -->
                <div class="featured-grid-bottom">
                    <div class="featured-block">
                        <h4><i class="fas fa-info-circle"></i> De quoi s'agit-il ?</h4>
                        <p>
                            Conçu pour améliorer l'expérience des administrateurs de serveurs Spigot/Paper, il fournit une interface graphique conviviale pour gérer les commandes et fonctionnalités d'EssentialsX sans passer par la ligne de commande.
                        </p>
                    </div>

                    <div class="featured-block">
                        <h4><i class="fas fa-cogs"></i> Fonctionnalités clés</h4>
                        <ul class="featured-list">
                            <li>Gestion fluide des homes, kits et warps.</li>
                            <li>Affichage des balances et gestion de l'économie.</li>
                            <li>Support de la vente d'items et de la commande /whois.</li>
                        </ul>
                    </div>

                    <div class="featured-metrics-col">
                        <div class="metric-item">
                            <i class="fas fa-server"></i>
                            <div>
                                <strong>~550</strong>
                                <span>Serveurs actifs</span>
                            </div>
                        </div>
                        <div class="metric-item">
                            <i class="fas fa-users"></i>
                            <div>
                                <strong>~700</strong>
                                <span>Joueurs en moyenne</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions de fin de carte -->
                <div class="featured-actions-row">
                    <a href="/projets/essentialsx-gui" class="btn btn-fill">Découvrir les détails <i class="fas fa-arrow-right"></i></a>
                    <a href="https://github.com/SniperTVmc/" target="_blank" class="btn btn-outline" aria-label="Voir sur GitHub"><i class="fab fa-github"></i> Code source</a>
                    <a href="https://modrinth.com/project/essentialsx-gui" target="_blank" class="btn btn-outline" aria-label="Télécharger sur Modrinth">
                        <i class="favorite-icon icon-modrinth" aria-hidden="true"></i> Télécharger sur Modrinth
                    </a>
                </div>
            </div>
        </section>


        <!-- Footer -->
        <?php include __DIR__ . "/../includes/footer.php"; ?>

    </body>
</html>
