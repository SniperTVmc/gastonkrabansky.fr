<?php
declare(strict_types=1);

require_once __DIR__ . '/analytics.php';

try {
    require_once __DIR__ . '/database.php';
} catch (Throwable $e) {
    analytics_log_error($e);
    return;
}

if (!isset($pdo) || !analytics_allowed()) {
    return;
}

$uri = (string) ($_SERVER['REQUEST_URI'] ?? '/');
$ignored = [
    '.ico',
    '.css',
    '.js',
    '.png',
    '.jpg',
    '.jpeg',
    '.webp',
    '.svg',
    '.txt',
    '.xml',
    '.webmanifest',
];
$isStatic = (bool) preg_match(
    '/(' . implode('|', array_map('preg_quote', $ignored)) . ')$/i',
    parse_url($uri, PHP_URL_PATH) ?: ''
);
$isAdmin =
    str_starts_with($uri, '/admin') || str_starts_with($uri, '/pages/admin');
if ($isStatic || $isAdmin) {
    return;
}

$query = [];
parse_str((string) parse_url($uri, PHP_URL_QUERY), $query);
$session = analytics_session($pdo, [
    'page_url' => $uri,
    'referrer_url' => $_SERVER['HTTP_REFERER'] ?? '',
    'utm_source' => $query['utm_source'] ?? null,
    'utm_medium' => $query['utm_medium'] ?? null,
    'utm_campaign' => $query['utm_campaign'] ?? null,
    'utm_term' => $query['utm_term'] ?? null,
    'utm_content' => $query['utm_content'] ?? null,
]);
$analyticsWritten = analytics_event($pdo, $session, 'page_view', [
    'page_title' => $GLOBALS['seo']['title'] ?? null,
]);

/* Keep the old table as a compatibility fallback for installations that have
 * not imported the analytics schema yet. Never double-write a new event. */
if (!$analyticsWritten) {
    try {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $legacyHash = hash_hmac(
            'sha256',
            $ip,
            (string) (getenv('ANALYTICS_SECRET') ?: 'legacy')
        );
        [$device] = analytics_user_agent(
            (string) ($_SERVER['HTTP_USER_AGENT'] ?? '')
        );
        $stmt = $pdo->prepare(
            "INSERT INTO site_visits (ip_hash, page_url, action_type, referrer, device_type, visitor_lang) VALUES (?, ?, 'view', ?, ?, ?)"
        );
        $stmt->execute([
            $legacyHash,
            analytics_url($uri),
            $_SERVER['HTTP_REFERER'] ?? null,
            $device,
            substr((string) ($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? ''), 0, 2),
        ]);
    } catch (Throwable $e) {
        analytics_log_error($e);
    }
}
