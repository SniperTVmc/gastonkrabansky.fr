<?php require __DIR__ . '/_bootstrap.php';
$pageKey = 'geography';
$title = 'Géographie';
$countries = $query(
    'analytics_sessions',
    "SELECT COALESCE(NULLIF(country_code,''),'Inconnu') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY country_code ORDER BY value DESC LIMIT 20",
    [$since]
);
$languages = $query(
    'analytics_sessions',
    "SELECT COALESCE(NULLIF(language,''),'Inconnue') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY language ORDER BY value DESC LIMIT 12",
    [$since]
);
$regions = $query(
    'analytics_sessions',
    "SELECT COALESCE(NULLIF(region,''),'Inconnue') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY region ORDER BY value DESC LIMIT 12",
    [$since]
);
$charts = [
    ['title' => 'Pays', 'type' => 'bar'] + $chartRows($countries, 'Sessions'),
    ['title' => 'Langues', 'type' => 'doughnut'] +
    $chartRows($languages, 'Sessions'),
    ['title' => 'Régions', 'type' => 'bar'] + $chartRows($regions, 'Sessions'),
];
require __DIR__ . '/_layout.php';
