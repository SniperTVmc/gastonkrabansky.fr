<?php
session_start();
if (($_SESSION['admin_logged'] ?? false) !== true) {
    header('Location: /admin');
    exit;
}

require_once __DIR__ . '/../../includes/admin/realisations.php';
$items = adminLoadRealisations();
$saved = isset($_GET['saved']);
$deleted = isset($_GET['deleted']);
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!adminCheckCsrf((string) ($_POST['csrf_token'] ?? ''))) {
        $error = 'La session a expiré. Rechargez la page et recommencez.';
    } elseif (adminDeleteRealisation(trim((string) ($_POST['id'] ?? '')))) {
        header('Location: /admin/realisations?deleted=1');
        exit;
    } else {
        $error = 'Impossible de supprimer cette réalisation.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php include __DIR__ . '/../../includes/admin/header.php'; ?>
<body data-page="admin-realisations">
<?php include __DIR__ . '/../../includes/admin/navbar.php'; ?>
<div class="admin-main-content">
    <main class="admin-content-wrapper">
        <div class="admin-page-heading">
            <div>
                <span class="admin-eyebrow">Contenus BTS SIO</span>
                <h1>Réalisations</h1>
                <p>Gérez les fiches et les compétences mobilisées par chaque projet.</p>
            </div>
            <a class="btn btn-fill" href="/admin/realisations/new"><i class="fas fa-plus"></i> Nouvelle réalisation</a>
        </div>

        <?php if ($saved): ?>
            <div class="admin-notice admin-notice-success" role="status">La réalisation a été enregistrée.</div>
        <?php endif; ?>
        <?php if ($deleted): ?>
            <div class="admin-notice admin-notice-success" role="status">La réalisation a été supprimée.</div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="admin-notice admin-notice-warning" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <div class="admin-card admin-realisation-list">
            <?php if (!$items): ?>
                <p class="stats-muted">Aucune réalisation enregistrée.</p>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <?php $id = (string) ($item['id'] ?? ''); ?>
                    <article class="admin-realisation-row">
                        <div>
                            <h2><i class="<?= htmlspecialchars((string) ($item['icon'] ?? 'fas fa-laptop-code'), ENT_QUOTES, 'UTF-8') ?>"></i> <?= htmlspecialchars((string) ($item['title'] ?? $id), ENT_QUOTES, 'UTF-8') ?></h2>
                            <p><?= htmlspecialchars((string) ($item['period'] ?? 'Période non renseignée'), ENT_QUOTES, 'UTF-8') ?></p>
                            <?php if (!empty($item['updated_at'])): ?>
                                <small class="admin-updated-at"><i class="far fa-clock"></i> Mise à jour : <?= htmlspecialchars(adminFormatUpdatedAt((string) $item['updated_at']), ENT_QUOTES, 'UTF-8') ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="admin-row-actions">
                            <a class="btn btn-outline sm" href="/admin/realisations/<?= rawurlencode($id) ?>">Modifier <i class="fas fa-arrow-right"></i></a>
                            <form method="post" class="admin-delete-form" data-confirm="Supprimer définitivement cette réalisation et son fichier JSON ?">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
                                <button class="btn btn-danger sm" type="submit"><i class="fas fa-trash"></i> Supprimer</button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
    <?php include __DIR__ . '/../../includes/admin/footer.php'; ?>
</div>
</body>
</html>
