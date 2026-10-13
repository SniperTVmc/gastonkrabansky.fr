<?php require __DIR__ . '/_bootstrap.php';
$pageKey = 'audience';
$title = 'Audience';
$returning = $query(
    'analytics_sessions',
    "SELECT IF(is_returning=1,'Récurrents','Nouveaux') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY is_returning",
    [$since]
);
$depth = $query(
    'analytics_sessions',
    "SELECT CASE WHEN page_view_count=1 THEN '1 page' WHEN page_view_count BETWEEN 2 AND 3 THEN '2–3 pages' ELSE '4+ pages' END label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY label ORDER BY page_view_count",
    [$since]
);
$hours = $query(
    'analytics_sessions',
    'SELECT HOUR(started_at) label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY HOUR(started_at) ORDER BY HOUR(started_at)',
    [$since]
);
$charts = [
    ['title' => 'Nouveaux et récurrents', 'type' => 'doughnut'] +
    $chartRows($returning, 'Sessions'),
    ['title' => 'Profondeur de navigation', 'type' => 'bar'] +
    $chartRows($depth, 'Sessions'),
    ['title' => 'Sessions par heure', 'type' => 'line'] +
    $chartRows($hours, 'Sessions'),
];
require __DIR__ . '/_layout.php';
