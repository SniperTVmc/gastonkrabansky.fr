<?php
$title = $title ?? 'Statistiques';
$rows = $rows ?? [];
$charts = $charts ?? [];
$tables = $tables ?? [];
$pageKey = $pageKey ?? 'summary';
$statsAction =
        $pageKey === 'summary'
                ? '/admin/stats'
                : '/admin/stats/' . rawurlencode($pageKey);
?>
<!doctype html><html lang="fr"><?php include __DIR__ .
        '/../../../includes/admin/header.php'; ?><body data-page="admin-stats-<?= $h(
        $pageKey
) ?>"><?php include __DIR__ . '/../../../includes/admin/navbar.php'; ?>
<main class="admin-main-content"><div class="admin-content-wrapper">
        <div class="admin-banner"><div class="admin-banner-text"><h1><?= $h(
                            $title
                    ) ?> 📊</h1><p><?= $pageKey === 'summary'
                            ? 'Vue d’ensemble de la fréquentation du site.'
                            : 'Analyse détaillée de cette catégorie.' ?><br><span class="stats-period-range"><?= $h(
                                $periodLabel
                        ) ?> · du <?= $h($sinceDate->format('d/m/Y H:i')) ?> au <?= $h(
                                $untilDate->format('d/m/Y H:i')
                        ) ?></span></p></div>
            <form class="stats-filter" method="get" action="<?= $h(
                    $statsAction
            ) ?>"><label for="period">Période</label><select id="period" name="period" class="stats-period-select"><?php foreach (
                            $periods
                            as $key => $config
                    ): ?><option value="<?= $h($key) ?>" <?= $period === $key
                            ? 'selected'
                            : '' ?>><?= $h(
                            $config['label']
                    ) ?></option><?php endforeach; ?></select><noscript><button type="submit">Appliquer</button></noscript></form></div>
        <?php if (
                $missing
        ): ?><div class="admin-notice admin-notice-warning"><i class="fas fa-circle-info"></i> Schéma analytique incomplet : <?= $h(
                    implode(', ', array_keys($missing))
            ) ?>. Les visualisations concernées sont masquées.</div><?php endif; ?>
        <?php if ($pageKey === 'summary'): ?><div class="admin-kpi-grid"><?php foreach (
                [
                        ['Vues', $base['views'], 'fa-eye', $number, ''],
                        ['Visiteurs uniques', $base['visitors'], 'fa-users', $number, ''],
                        ['Sessions', $base['sessions'], 'fa-clock', $number, ''],
                        [
                                'Durée moyenne',
                                $base['duration'],
                                'fa-hourglass-half',
                                $decimal,
                                ' s',
                        ],
                        [
                                'Pages/session',
                                $base['pages_session'],
                                'fa-layer-group',
                                $decimal,
                                '',
                        ],
                        [
                                'Taux de rebond',
                                $base['bounce'],
                                'fa-arrow-right-from-bracket',
                                $decimal,
                                ' %',
                        ],
                ]
                as [$label, $value, $icon, $format, $suffix]
        ): ?><div class="admin-card kpi-card"><i class="fas <?= $icon ?> fa-2x"></i><div class="kpi-details"><span><?= $h(
                            $label
                    ) ?></span><h3><?= $format($value) .
                    $h($suffix) ?></h3></div></div><?php endforeach; ?></div><?php endif; ?>
        <div class="stats-grid"><?php foreach (
                    $charts
                    as $index => $chart
            ): ?><section class="admin-card stats-panel"><h2><?= $h(
                            $chart['title'] ?? 'Graphique'
                    ) ?></h2><div class="stats-chart-container"><canvas class="stats-chart" id="stats-chart-<?= $index ?>" aria-label="<?= $h(
                            $chart['title'] ?? 'Graphique'
                    ) ?>" data-config="<?= $h(
                            json_encode(
                                    [
                                            'type' => $chart['type'] ?? 'bar',
                                            'labels' => $chart['labels'] ?? [],
                                            'datasets' => $chart['datasets'] ?? [],
                                    ],
                                    JSON_UNESCAPED_UNICODE
                            )
                    ) ?>"></canvas></div></section><?php endforeach; ?></div>
        <?php foreach (
                $tables
                as $table
        ): ?><section class="admin-card stats-panel"><h2><?= $h(
                        $table['title'] ?? 'Détails'
                ) ?></h2><div class="table-responsive"><table class="competences-table"><thead><tr><?php foreach (
                                $table['columns'] ?? ['Dimension', 'Occurrences']
                                as $column
                        ): ?><th><?= $h($column) ?></th><?php endforeach; ?></tr></thead><tbody><?php
                    $tableRows = $table['rows'] ?? [];
                    if (!$tableRows): ?><tr><td colspan="<?= count(
                                $table['columns'] ?? [1, 2]
                        ) ?>" class="empty-cell">Aucune donnée pour cette période.</td></tr><?php else:foreach (
                            $tableRows
                            as $row
                    ): ?><tr><?php foreach ($row as $value): ?><td class="url-cell"><?= $h(
                            $value
                    ) ?></td><?php endforeach; ?></tr><?php endforeach;endif;
                    ?></tbody></table></div></section><?php endforeach; ?>
    </div><?php include __DIR__ .
            '/../../../includes/admin/footer.php'; ?></main></body></html>
