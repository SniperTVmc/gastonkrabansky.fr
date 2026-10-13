<nav class="navbar">
    <a href="/" class="logo">Gaston <span class="highlight">Krabansky</span></a>
    <ul class="nav-links">
        <li><a href="/" data-nav="accueil">Accueil</a></li>
        <li><a href="/competences" data-nav="competences">Compétences</a></li>
        <li><a href="/experiences" data-nav="experiences">Expériences</a></li>
        <li><a href="/projets" data-nav="projets">Projets</a></li>

        <li class="dropdown">
            <a href="/bts-sio" data-nav="bts-sio" class="dropdown-toggle">
                BTS SIO <i class="fas fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="/bts-sio">Présentation</a></li>
                <li><a href="/bts-sio/realisations">Réalisations</a></li>
                <li><a href="/bts-sio/veilles">Veilles</a></li>
            </ul>
        </li>

        <li><a href="/cv" data-nav="cv">CV</a></li>
        <li><a href="/contact" data-nav="contact">Contact</a></li>

        <?php if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true): ?>
            <li>
                <a href="/admin/dashboard" data-nav="admin" title="Tableau de bord Admin">
                    <i class="fas fa-user-shield"></i>
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <button class="burger" aria-label="Ouvrir le menu"><i class="fas fa-bars"></i></button>
</nav>