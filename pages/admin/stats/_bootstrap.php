<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['admin_logged'])) {
    header('Location: /admin');
    exit();
}
try {
    require_once __DIR__ . '/../../../includes/database.php';
    global $pdo;
} catch (Throwable $e) {
    $pdo = null;
}
$periods = [
    '24h' => ['days' => 1, 'label' => 'Dernières 24 heures'],
    '7j' => ['days' => 7, 'label' => '7 derniers jours'],
    '30j' => ['days' => 30, 'label' => '30 derniers jours'],
    '90j' => ['days' => 90, 'label' => '90 derniers jours'],
];
$requestedPeriod = is_string($_GET['period'] ?? null) ? $_GET['period'] : '';
$period = isset($periods[$requestedPeriod]) ? $requestedPeriod : '7j';
$now = new DateTimeImmutable('now');
try {
    $sinceDate = $now->modify('-' . $periods[$period]['days'] . ' days');
} catch (DateMalformedStringException $e) {
    $sinceDate = $now->modify('-7 days');
}
$since = $sinceDate->format('Y-m-d H:i:s');
$until = $now->format('Y-m-d H:i:s');
$untilDate = $now;
$periodLabel = $periods[$period]['label'];
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
$h = static fn($v): string => htmlspecialchars(
    (string) $v,
    ENT_QUOTES,
    'UTF-8'
);
$number = static fn($v): string => number_format((float) $v, 0, ',', ' ');
$decimal = static fn($v): string => number_format((float) $v, 1, ',', ' ');
$missing = [];
$query = static function (string $table, string $sql, array $params = []) use (
    &$missing,
    $pdo
): array {
    if (!$pdo) {
        $missing[$table] = true;
        return [];
    }
    try {
        $pdo->query("SELECT 1 FROM `$table` LIMIT 1");
        $s = $pdo->prepare($sql);
        $s->execute($params);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable) {
        $missing[$table] = true;
        return [];
    }
};
$scalar = static function (string $table, string $sql, array $params = []) use (
    $query
): float {
    $r = $query($table, $sql, $params);
    return (float) ($r[0]['value'] ?? 0);
};
$base = [
    'views' => $scalar(
        'analytics_events',
        "SELECT COUNT(*) value FROM analytics_events WHERE event_type='page_view' AND occurred_at>=?",
        [$since]
    ),
    'visitors' => $scalar(
        'analytics_sessions',
        'SELECT COUNT(DISTINCT visitor_key) value FROM analytics_sessions WHERE started_at>=?',
        [$since]
    ),
    'sessions' => $scalar(
        'analytics_sessions',
        'SELECT COUNT(*) value FROM analytics_sessions WHERE started_at>=?',
        [$since]
    ),
    'duration' => $scalar(
        'analytics_sessions',
        'SELECT COALESCE(AVG(duration_seconds),0) value FROM analytics_sessions WHERE started_at>=?',
        [$since]
    ),
    'pages_session' => $scalar(
        'analytics_sessions',
        'SELECT COALESCE(AVG(page_view_count),0) value FROM analytics_sessions WHERE started_at>=?',
        [$since]
    ),
    'bounce' => $scalar(
        'analytics_sessions',
        'SELECT COALESCE(AVG(page_view_count=1)*100,0) value FROM analytics_sessions WHERE started_at>=?',
        [$since]
    ),
];
$chartRows = static function (
    array $rows,
    string $label = 'Occurrences'
): array {
    return [
        'labels' => array_values(
            array_map(static fn($r) => (string) ($r['label'] ?? ''), $rows)
        ),
        'datasets' => [
            [
                'label' => $label,
                'data' => array_values(
                    array_map(
                        static fn($r) => (float) ($r['value'] ?? 0),
                        $rows
                    )
                ),
            ],
        ],
    ];
};
