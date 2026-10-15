<aside class="admin-sidebar">
    <div class="admin-sidebar-brand">
        <a href="/admin/dashboard">Administration</a>
    </div>

    <ul class="admin-nav-links">
        <li>
            <a href="/admin/dashboard" data-nav="admin-dashboard">
                <i class="fas fa-chart-line"></i> Tableau de bord
            </a>
        </li>
        <?php $realisationsActive = str_starts_with(trim(parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH) ?: '', '/'), 'admin/realisations'); ?>
        <li>
            <a href="/admin/realisations" data-nav="admin-realisations" class="<?= $realisationsActive ? 'active' : '' ?>">
                <i class="fas fa-briefcase"></i> Réalisations
            </a>
        </li>
        <?php
            $statsPath = trim(parse_url((string)($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH) ?: '', '/');
            $statsActive = str_starts_with($statsPath, 'admin/stats') || str_starts_with($statsPath, 'stats');
            $statsSections = [
                '' => ['Résumé', 'fa-chart-pie'],
                'acquisition' => ['Acquisition', 'fa-bullseye'],
                'audience' => ['Audience', 'fa-users'],
                'content' => ['Contenu', 'fa-file-lines'],
                'interactions' => ['Interactions', 'fa-hand-pointer'],
                'technology' => ['Technologie', 'fa-microchip'],
                'geography' => ['Géographie', 'fa-earth-europe'],
            ];
            $currentStatsSection = trim(str_replace(['admin/stats', 'stats'], '', $statsPath), '/');
        ?>
        <li class="admin-nav-group <?= $statsActive ? 'is-open' : '' ?>">
            <a href="/admin/stats" data-nav="admin-stats" class="<?= $statsActive ? 'active' : '' ?>">
                <i class="fas fa-chart-pie"></i> Statistiques
            </a>
            <button type="button" class="admin-nav-toggle" aria-expanded="<?= $statsActive ? 'true' : 'false' ?>" aria-controls="stats-submenu"><i class="fas fa-chevron-down admin-nav-chevron" aria-hidden="true"></i><span class="sr-only">Afficher les catégories statistiques</span></button>
            <div class="admin-nav-submenu" id="stats-submenu">
                <?php foreach ($statsSections as $path => [$label, $icon]): ?>
                    <a href="/admin/stats<?= $path !== '' ? '/' . $path : '' ?>" data-nav="admin-stats-<?= $path !== '' ? $path : 'summary' ?>" class="<?= $currentStatsSection === $path ? 'active' : '' ?>">
                        <i class="fas <?= htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') ?>"></i> <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </li>
    </ul>

    <div class="admin-sidebar-footer">
        <?php if (isset($_SESSION['admin_user'])): ?>
            <div class="admin-user-tag">
                <i class="fas fa-user-shield"></i> <?= htmlspecialchars($_SESSION['admin_user']) ?>
            </div>
        <?php endif; ?>
        <a href="/admin/logout" class="admin-logout-btn">
            <i class="fas fa-power-off"></i> Déconnexion
        </a>
    </div>
</aside>