<?php require __DIR__ . '/_bootstrap.php';
$pageKey = 'acquisition';
$title = 'Acquisition';
$sources = $query(
    'analytics_sessions',
    "SELECT COALESCE(NULLIF(utm_source,''),NULLIF(referrer_host,''),'Direct') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY label ORDER BY value DESC LIMIT 12",
    [$since]
);
$mediums = $query(
    'analytics_sessions',
    "SELECT COALESCE(NULLIF(utm_medium,''),'Non défini') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY utm_medium ORDER BY value DESC LIMIT 12",
    [$since]
);
$campaigns = $query(
    'analytics_sessions',
    "SELECT COALESCE(NULLIF(utm_campaign,''),'Sans campagne') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY utm_campaign ORDER BY value DESC LIMIT 12",
    [$since]
);
$charts = [
    ['title' => 'Sources', 'type' => 'bar'] + $chartRows($sources, 'Sessions'),
    ['title' => 'Supports UTM', 'type' => 'doughnut'] +
    $chartRows($mediums, 'Sessions'),
    ['title' => 'Campagnes', 'type' => 'bar'] +
    $chartRows($campaigns, 'Sessions'),
];
require __DIR__ . '/_layout.php';
