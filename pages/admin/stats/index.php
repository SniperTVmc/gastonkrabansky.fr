<?php require __DIR__ . '/_bootstrap.php';
$pageKey = 'summary';
$title = 'Synthèse analytique';
$trend = $query(
    'analytics_events',
    "SELECT DATE(occurred_at) label,COUNT(*) value FROM analytics_events WHERE event_type='page_view' AND occurred_at>=? GROUP BY DATE(occurred_at) ORDER BY DATE(occurred_at)",
    [$since]
);
$pages = $query(
    'analytics_events',
    "SELECT COALESCE(page_url,'/') label,COUNT(*) value FROM analytics_events WHERE event_type='page_view' AND occurred_at>=? GROUP BY page_url ORDER BY value DESC LIMIT 10",
    [$since]
);
$devices = $query(
    'analytics_sessions',
    "SELECT COALESCE(device_type,'unknown') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY device_type ORDER BY value DESC",
    [$since]
);
$languages = $query(
    'analytics_sessions',
    "SELECT COALESCE(NULLIF(language,''),'unknown') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY language ORDER BY value DESC LIMIT 8",
    [$since]
);
$charts = [
    ['title' => 'Évolution des vues', 'type' => 'line'] +
    $chartRows($trend, 'Vues'),
    ['title' => 'Appareils', 'type' => 'doughnut'] +
    $chartRows($devices, 'Sessions'),
    ['title' => 'Langues', 'type' => 'doughnut'] +
    $chartRows($languages, 'Sessions'),
];
$tables = [
    [
        'title' => 'Pages les plus vues',
        'columns' => ['Page', 'Vues'],
        'rows' => array_map(
            static fn($r) => [$r['label'], $number($r['value'])],
            $pages
        ),
    ],
];
require __DIR__ . '/_layout.php';
