<?php require __DIR__ . '/_bootstrap.php';
$pageKey = 'technology';
$title = 'Technologie';
$devices = $query(
    'analytics_sessions',
    "SELECT COALESCE(device_type,'unknown') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY device_type ORDER BY value DESC",
    [$since]
);
$browsers = $query(
    'analytics_sessions',
    "SELECT COALESCE(NULLIF(browser_name,''),'unknown') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY browser_name ORDER BY value DESC LIMIT 12",
    [$since]
);
$os = $query(
    'analytics_sessions',
    "SELECT COALESCE(NULLIF(os_name,''),'unknown') label,COUNT(*) value FROM analytics_sessions WHERE started_at>=? GROUP BY os_name ORDER BY value DESC LIMIT 12",
    [$since]
);
$charts = [
    ['title' => 'Appareils', 'type' => 'doughnut'] +
    $chartRows($devices, 'Sessions'),
    ['title' => 'Navigateurs', 'type' => 'bar'] +
    $chartRows($browsers, 'Sessions'),
    ['title' => 'Systèmes d’exploitation', 'type' => 'bar'] +
    $chartRows($os, 'Sessions'),
];
require __DIR__ . '/_layout.php';
