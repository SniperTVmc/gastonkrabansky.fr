<?php
session_start();
if (($_SESSION['admin_logged'] ?? false) !== true) {
    header('Location: /admin');
    exit;
}

require_once __DIR__ . '/../../includes/admin/realisations.php';

$isNew = isset($_GET['new']);
$id = trim((string) ($_GET['id'] ?? ''));
$item = $isNew ? [
    'id' => '',
    'rank' => 0,
    'title' => '',
    'description' => '',
    'icon' => 'fas fa-laptop-code',
    'period' => '',
    'link' => [],
    'blocs_mobilises' => [],
    'realisation_details' => [],
] : adminLoadRealisation($id);
if (!$isNew && !$item) {
    http_response_code(404);
    exit('Réalisation introuvable.');
}

$referentiel = adminLoadReferentiel();
$referentielBlocks = array_values($referentiel);
$dateValues = adminPeriodDateValues((string) ($item['period'] ?? ''));
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!adminCheckCsrf((string) ($_POST['csrf_token'] ?? ''))) {
        $error = 'La session du formulaire a expiré. Rechargez la page et recommencez.';
    } else {
        $postedId = trim((string) ($_POST['id'] ?? ''));
        $title = trim((string) ($_POST['title'] ?? ''));
        $icon = trim((string) ($_POST['icon'] ?? ''));
        $startDate = trim((string) ($_POST['period_start'] ?? ''));
        $endDate = trim((string) ($_POST['period_end'] ?? '')) ?: date('Y-12-31');
        if (!adminRealisationIsValidId($postedId) || (!$isNew && $postedId !== $id)) {
            $error = 'Identifiant de réalisation invalide.';
        } elseif ($isNew && adminLoadRealisation($postedId)) {
            $error = 'Cet identifiant est déjà utilisé.';
        } elseif ($title === '' || $icon === '' || $startDate === '') {
            $error = 'Les champs identifiant, titre, icône et début de période sont obligatoires.';
        } elseif (!adminFormatPeriod($startDate, $endDate) || $endDate < $startDate) {
            $error = 'Les dates de période sont invalides.';
        } else {
            $item['id'] = $postedId;
            $item['title'] = $title;
            $item['description'] = trim((string) ($_POST['description'] ?? ''));
            $item['rank'] = max(0, (int) ($_POST['rank'] ?? 0));
            $item['icon'] = $icon;
            $item['updated_at'] = date('c');
            $item['period'] = adminFormatPeriod($startDate, $endDate);
            $linkUrl = trim((string) ($_POST['link_url'] ?? ''));
            $linkLabel = trim((string) ($_POST['link_label'] ?? ''));
            if ($linkUrl !== '' || $linkLabel !== '') {
                $item['link'] = ['url' => $linkUrl, 'label' => $linkLabel];
            } else {
                unset($item['link']);
            }
            $item['blocs_mobilises'] = array_values(array_unique(array_filter(
                array_map('strval', (array) ($_POST['blocs_mobilises'] ?? [])),
                static fn(string $value): bool => ctype_digit($value) && array_key_exists((int) $value, $referentielBlocks)
            )));
            $item['realisation_details'] = [];
            $selected = (array) ($_POST['skills'] ?? []);
            $descriptions = (array) ($_POST['descriptions'] ?? []);

            foreach ($referentiel as $blocKey => $bloc) {
                foreach (array_keys((array) ($bloc['competences'] ?? [])) as $competenceIndex => $competenceName) {
                    foreach (array_keys((array) ($bloc['competences'][$competenceName] ?? [])) as $subIndex) {
                        if (isset($selected[$blocKey][$competenceIndex][$subIndex])) {
                            $item['realisation_details'][$blocKey][(string) $competenceIndex][(string) $subIndex] =
                                trim((string) ($descriptions[$blocKey][$competenceIndex][$subIndex] ?? ''));
                        }
                    }
                }
            }

            if (adminSaveRealisation($postedId, $item)) {
                header('Location: /admin/realisations?saved=1');
                exit;
            }
            $error = 'Impossible d’écrire le fichier JSON de cette réalisation.';
        }
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
                <a href="/admin/realisations" class="back-link"><i class="fas fa-arrow-left"></i> Retour aux réalisations</a>
                <span class="admin-eyebrow"><?= $isNew ? 'Nouvelle fiche JSON' : 'Édition JSON · ' . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?></span>
                <h1><?= $isNew ? 'Créer une réalisation' : 'Modifier la réalisation' ?></h1>
            </div>
        </div>

        <?php if ($error): ?><div class="admin-notice admin-notice-warning" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>

        <form method="post" action="<?= htmlspecialchars($isNew ? '/admin/realisations/new' : '/admin/realisations/' . rawurlencode($id), ENT_QUOTES, 'UTF-8') ?>" class="admin-realisation-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <section class="admin-card">
                <h2 class="admin-card-title"><i class="fas fa-circle-info"></i> Informations générales</h2>
                <div class="admin-form-grid">
                    <label class="admin-id-field">Identifiant unique <span>Obligatoire · non modifiable après création</span><input type="text" name="id" required pattern="[a-z0-9][a-z0-9-]*" value="<?= htmlspecialchars((string) ($item['id'] ?? $id), ENT_QUOTES, 'UTF-8') ?>" <?= $isNew ? '' : 'readonly' ?>></label>
                    <?php if (!$isNew): ?><input type="hidden" name="id" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>"><?php endif; ?>
                    <label class="admin-title-field">Titre *<input type="text" name="title" required value="<?= htmlspecialchars((string) ($item['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></label>
                    <label class="admin-description-field">Description <span>(contexte, objectifs, rôle dans le projet...)</span><textarea name="description" rows="5" placeholder="Présentez le contexte de la réalisation et les objectifs du projet..."><?= htmlspecialchars((string) ($item['description'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea><small class="admin-field-help">Les retours à la ligne sont conservés.</small></label>
                    <label>Rang<input type="number" name="rank" min="0" value="<?= (int) ($item['rank'] ?? 0) ?>"></label>
                    <label>Icône Font Awesome *<div class="admin-icon-input"><input id="realisation-icon" type="text" name="icon" required value="<?= htmlspecialchars((string) ($item['icon'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"><span id="realisation-icon-preview" aria-hidden="true"></span></div><small id="realisation-icon-status" class="admin-field-help"></small></label>
                    <label>Début de période *<input type="date" name="period_start" required value="<?= htmlspecialchars($dateValues[0], ENT_QUOTES, 'UTF-8') ?>"></label>
                    <label>Fin de période <span>(par défaut : année actuelle)</span><input type="date" name="period_end" value="<?= htmlspecialchars($dateValues[1], ENT_QUOTES, 'UTF-8') ?>"></label>
                    <label>Lien <span>(optionnel, interne ou externe)</span><input type="text" name="link_url" placeholder="/projets/mon-projet ou https://exemple.fr" value="<?= htmlspecialchars((string) ($item['link']['url'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></label>
                    <label>Libellé du lien <span>(optionnel)</span><input type="text" name="link_label" value="<?= htmlspecialchars((string) ($item['link']['label'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></label>
                </div>
            </section>

            <section class="admin-card">
                <h2 class="admin-card-title"><i class="fas fa-layer-group"></i> Blocs mobilisés</h2>
                <div class="admin-checkbox-list">
                    <?php foreach (array_values($referentiel) as $blocIndex => $bloc): ?>
                        <?php $blocName = (string) ($bloc['nom'] ?? $blocIndex); ?>
                        <label><input type="checkbox" name="blocs_mobilises[]" value="<?= $blocIndex ?>" <?= in_array((string) $blocIndex, array_map('strval', $item['blocs_mobilises'] ?? []), true) ? 'checked' : '' ?>> <?= htmlspecialchars($blocName, ENT_QUOTES, 'UTF-8') ?></label>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="admin-card">
                <h2 class="admin-card-title"><i class="fas fa-list-check"></i> Compétences et preuves</h2>
                <p class="stats-muted">Cochez une sous-compétence pour faire apparaître son champ de preuve ou d’explication.</p>
                <div class="tab-buttons admin-editor-tabs">
                    <?php $first = true; foreach ($referentiel as $blocKey => $bloc): ?>
                        <button type="button" class="tab-btn<?= $first ? ' active' : '' ?>" data-target="#editor-<?= htmlspecialchars($blocKey, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) ($bloc['nom'] ?? $blocKey), ENT_QUOTES, 'UTF-8') ?></button>
                        <?php $first = false; endforeach; ?>
                </div>
                <?php $first = true; foreach ($referentiel as $blocKey => $bloc): ?>
                    <div class="tab-content<?= $first ? ' active-content' : '' ?>" id="editor-<?= htmlspecialchars($blocKey, ENT_QUOTES, 'UTF-8') ?>">
                        <?php foreach ((array) ($bloc['competences'] ?? []) as $competenceName => $subCompetences): ?>
                            <?php $competenceIndex = array_search($competenceName, array_keys((array) ($bloc['competences'] ?? [])), true); ?>
                            <fieldset class="admin-skill-group">
                                <legend><?= htmlspecialchars((string) $competenceName, ENT_QUOTES, 'UTF-8') ?></legend>
                                <?php foreach ($subCompetences as $subIndex => $subCompetence): ?>
                                    <?php $checked = array_key_exists((string) $subIndex, $item['realisation_details'][$blocKey][(string) $competenceIndex] ?? []); ?>
                                    <div class="admin-skill-item">
                                        <label class="admin-skill-check"><input type="checkbox" name="skills[<?= htmlspecialchars($blocKey, ENT_QUOTES, 'UTF-8') ?>][<?= $competenceIndex ?>][<?= $subIndex ?>]" value="1" <?= $checked ? 'checked' : '' ?>> <?= htmlspecialchars((string) $subCompetence, ENT_QUOTES, 'UTF-8') ?></label>
                                        <textarea name="descriptions[<?= htmlspecialchars($blocKey, ENT_QUOTES, 'UTF-8') ?>][<?= $competenceIndex ?>][<?= $subIndex ?>]" rows="2" placeholder="Comment cette compétence a-t-elle été validée ? Preuve, outil, livrable..."><?= $checked ? htmlspecialchars((string) ($item['realisation_details'][$blocKey][(string) $competenceIndex][(string) $subIndex] ?? ''), ENT_QUOTES, 'UTF-8') : '' ?></textarea>
                                    </div>
                                <?php endforeach; ?>
                            </fieldset>
                        <?php endforeach; ?>
                    </div>
                    <?php $first = false; endforeach; ?>
            </section>
            <div class="admin-form-actions"><a href="/admin/realisations" class="btn btn-outline">Annuler</a><button type="submit" class="btn btn-fill"><i class="fas fa-save"></i> Enregistrer dans le JSON</button></div>
        </form>
    </main>
    <?php include __DIR__ . '/../../includes/admin/footer.php'; ?>
</div>
</body>
</html>
