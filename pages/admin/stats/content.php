<?php require __DIR__ . '/_bootstrap.php';
$pageKey = 'content';
$title = 'Contenu';
$pages = $query(
    'analytics_events',
    "SELECT COALESCE(page_url,'/') label,COUNT(*) value FROM analytics_events WHERE event_type='page_view' AND occurred_at>=? GROUP BY page_url ORDER BY value DESC LIMIT 20",
    [$since]
);
$entries = $query(
    'analytics_sessions',
    "SELECT COALESCE(entry_url,landing_page,'/') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY label ORDER BY value DESC LIMIT 10",
    [$since]
);
$exits = $query(
    'analytics_sessions',
    "SELECT COALESCE(exit_url,'/') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY label ORDER BY value DESC LIMIT 10",
    [$since]
);
$trend = $query(
    'analytics_events',
    "SELECT DATE(occurred_at) label,COUNT(*) value FROM analytics_events WHERE event_type='page_view' AND occurred_at>=? GROUP BY DATE(occurred_at) ORDER BY DATE(occurred_at)",
    [$since]
);
$charts = [
    ['title' => 'Pages vues', 'type' => 'bar'] + $chartRows($pages, 'Vues'),
    ['title' => 'Évolution des pages vues', 'type' => 'line'] +
    $chartRows($trend, 'Vues'),
];
$tables = [
    [
        'title' => 'Pages d’entrée',
        'columns' => ['Page', 'Sessions'],
        'rows' => array_map(
            static fn($r) => [$r['label'], $number($r['value'])],
            $entries
        ),
    ],
    [
        'title' => 'Pages de sortie',
        'columns' => ['Page', 'Sessions'],
        'rows' => array_map(
            static fn($r) => [$r['label'], $number($r['value'])],
            $exits
        ),
    ],
];
require __DIR__ . '/_layout.php';
