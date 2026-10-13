<?php
    session_start();
    if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
        header('Location: /admin');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Head -->
    <?php include __DIR__ . "/../../includes/admin/header.php"; ?>

    <body data-page="admin-dashboard">


        <!-- Navigation -->
        <?php include __DIR__ . "/../../includes/admin/navbar.php"; ?>

        <!-- Page Content -->
        <div class="admin-main-content">
            <div class="admin-content-wrapper">

                <div class="admin-banner">
                    <div class="admin-banner-text">
                        <h1>Bienvenue, <?= htmlspecialchars($_SESSION['admin_user']) ?> 👋</h1>
                        <p>Tableau de bord de gestion du site web
                    </div>
                    <div class="admin-banner-status">
                        <span class="status-dot"></span>
                        Connecté en tant qu'administrateur
                    </div>
                </div>

                <div class="admin-dashboard-grid">

                    <div class="admin-card admin-about-card">
                        <img src="/assets/images/profile/logo.webp" alt="Avatar Gaston Krabansky" class="admin-about-img">
                        <div class="admin-about-info">
                            <h3>Panneau d'Administration</h3>
                            <p>
                                Cet espace permet d'avoir une vue d'ensemble sur l'état du site et de gérer ses contenus de manière centralisée.
                                Une vue d'ensemble des statistiques et des informations importantes est disponible pour faciliter la gestion du site.
                            </p>
                            <a href="/" target="_blank" class="btn btn-fill sm">
                                <i class="fas fa-globe"></i> Retourner sur le site
                            </a>
                        </div>
                    </div>

                    <div class="admin-card admin-quick-stats">
                        <div class="stat-item">
                            <i class="fas fa-shield-halved"></i>
                            <div class="stat-item-details">
                                <span>Version du site</span>
                                <strong>1.0.0</strong>
                            </div>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-code-branch"></i>
                            <div class="stat-item-details">
                                <span>Dernière mise à jour</span>
                                <strong>13 Octobre 2026</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Footer -->
            <?php include __DIR__ . "/../../includes/admin/footer.php"; ?>

        </div>
    </body>
</html>