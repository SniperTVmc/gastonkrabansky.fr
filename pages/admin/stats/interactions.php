<?php require __DIR__ . '/_bootstrap.php';
$pageKey = 'interactions';
$title = 'Interactions';
$types = $query(
    'analytics_events',
    "SELECT event_type label,COUNT(*) value FROM analytics_events WHERE event_type<>'page_view' AND occurred_at>=? GROUP BY event_type ORDER BY value DESC LIMIT 20",
    [$since]
);
$targets = $query(
    'analytics_events',
    "SELECT COALESCE(NULLIF(target_label,''),NULLIF(target_id,''),target_type,'Sans libellé') label,COUNT(*) value FROM analytics_events WHERE event_type<>'page_view' AND occurred_at>=? GROUP BY label ORDER BY value DESC LIMIT 20",
    [$since]
);
$charts = [
    ['title' => 'Types d’événement', 'type' => 'bar'] +
    $chartRows($types, 'Événements'),
    ['title' => 'Cibles les plus utilisées', 'type' => 'bar'] +
    $chartRows($targets, 'Interactions'),
];
require __DIR__ . '/_layout.php';
