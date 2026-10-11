<?php
    $page_seo_key = 'bts_presentation';
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
           <a href="/">Accueil</a> / <a href="/bts-sio">BTS SIO</a> / <span class="current">Présentation</span>
        </div>


        <!-- Page Header -->
        <div class="page-header">
            <h1>Le <span>BTS SIO</span> - Option SLAM</h1>
            <p>Une présentation rapide du diplôme, pensée pour un recruteur qui découvre le BTS SIO pour la première fois.</p>
        </div>


        <!-- Main Content -->
        <section class="container">
            <div class="info-block">
                <h3><i class="fas fa-graduation-cap"></i> Qu'est-ce que le BTS SIO ?</h3>
                <p>
                    Le BTS Services Informatiques aux Organisations (SIO) est un diplôme d'État de niveau Bac+2
                    (niveau 5), préparé en deux ans, qui forme aux métiers de l'informatique au service des
                    entreprises et administrations. Il se prépare en formation initiale ou en alternance et se
                    termine par une certification par blocs de compétences.
                </p>
            </div>

            <div class="info-block">
                <h3><i class="fas fa-code-branch"></i> Les deux options</h3>
                <p style="margin-bottom:15px;">
                    À partir de la première année, chaque étudiant choisit l'une des deux options du BTS SIO :
                </p>
                <ul style="margin-left:20px;">
                    <li style="color:var(--text-secondary); margin-bottom:10px;">
                        <strong style="color:var(--text-color);">Option SISR</strong> (Solutions d'Infrastructure, Systèmes et Réseaux) :
                        orientée vers l'administration des réseaux, des serveurs et de la sécurité informatique.
                    </li>
                    <li style="color:var(--text-secondary);">
                        <strong style="color:var(--main-color);">Option SLAM</strong> (Solutions Logicielles et Applications Métiers) : <em>c'est mon option</em>,
                        orientée vers le développement, la maintenance et l'évolution d'applications informatiques
                        (sites web, logiciels métiers, bases de données...).
                    </li>
                </ul>
            </div>

            <h2 class="section-title" style="margin-top:60px;">Les <span>6 blocs de compétences</span></h2>
            <p class="section-lead">
                La formation est structurée autour de 6 grands blocs de compétences, communs aux deux options,
                qui sont mobilisés à travers des réalisations concrètes tout au long des deux années.
            </p>
            <div class="blocs-grid">
                <div class="bloc-card">
                    <div class="bloc-number">Bloc 1</div>
                    <h4>Gérer le patrimoine informatique</h4>
                    <p style="color:var(--text-secondary); font-size:0.9rem; margin-top:8px;">
                        Recenser les ressources numériques, gérer les habilitations, les sauvegardes et la continuité de service.
                    </p>
                </div>
                <div class="bloc-card">
                    <div class="bloc-number">Bloc 2</div>
                    <h4>Répondre aux incidents et aux demandes</h4>
                    <p style="color:var(--text-secondary); font-size:0.9rem; margin-top:8px;">
                        Collecter, suivre et traiter les demandes d'assistance et d'évolution des utilisateurs.
                    </p>
                </div>
                <div class="bloc-card">
                    <div class="bloc-number">Bloc 3</div>
                    <h4>Développer la présence en ligne</h4>
                    <p style="color:var(--text-secondary); font-size:0.9rem; margin-top:8px;">
                        Valoriser l'image de l'organisation sur le web, référencer et faire évoluer un site.
                    </p>
                </div>
                <div class="bloc-card">
                    <div class="bloc-number">Bloc 4</div>
                    <h4>Travailler en mode projet</h4>
                    <p style="color:var(--text-secondary); font-size:0.9rem; margin-top:8px;">
                        Analyser les objectifs d'un projet, planifier les activités et suivre les indicateurs d'avancement.
                    </p>
                </div>
                <div class="bloc-card">
                    <div class="bloc-number">Bloc 5</div>
                    <h4>Mettre à disposition un service informatique</h4>
                    <p style="color:var(--text-secondary); font-size:0.9rem; margin-top:8px;">
                        Tester, déployer un service et accompagner les utilisateurs dans sa prise en main.
                    </p>
                </div>
                <div class="bloc-card">
                    <div class="bloc-number">Bloc 6</div>
                    <h4>Organiser son développement professionnel</h4>
                    <p style="color:var(--text-secondary); font-size:0.9rem; margin-top:8px;">
                        Mettre en place sa veille informationnelle, gérer son identité et son projet professionnel.
                    </p>
                </div>
            </div>

            <div class="info-block" style="margin-top:50px; text-align:center;">
                <h3 style="justify-content:center;"><i class="fas fa-clipboard-list"></i> L'épreuve E5</h3>
                <p style="margin-bottom:20px;">
                    Ce site fait office de support pour l'épreuve E5 du BTS SIO ("Expression et mise en valeur des
                    compétences informatiques"), qui prend la forme d'un portfolio numérique. Vous êtes actuellement
                    dans la section qui lui est dédiée.
                </p>
                <div class="overview-grid" style="text-align:left;">
                    <a href="/bts-sio/realisations" class="overview-card">
                        <i class="fas fa-list-check"></i>
                        <h3>Réalisations & Compétences</h3>
                        <p>Le détail des compétences mobilisées pour chaque réalisation effectuée durant la formation.</p>
                    </a>
                    <a href="/bts-sio/veilles" class="overview-card">
                        <i class="fas fa-magnifying-glass"></i>
                        <h3>Veilles technologiques</h3>
                        <p>Des articles de veille sur des sujets technologiques, rédigés dans le cadre de l'épreuve E5.</p>
                    </a>
                </div>
            </div>
        </section>


        <!-- Footer -->
        <?php include __DIR__ . "/../../includes/footer.php"; ?>

    </body>
</html>
