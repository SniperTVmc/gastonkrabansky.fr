<?php
declare(strict_types=1);

/**
 * Privacy-preserving analytics collector. Every public helper is deliberately
 * best-effort: analytics must never prevent a page or API response.
 */
function analytics_uuid_v4(): string
{
    try {
        $bytes = random_bytes(16);
    } catch (Throwable $e) {
        $bytes = hash('sha256', uniqid('', true), true);
    }
    $bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x40);
    $bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
}

function analytics_log_error(Throwable $error): void
{
    error_log(
        '[analytics] ' .
        substr(get_class($error) . ': ' . $error->getMessage(), 0, 500)
    );
}

function analytics_allowed(): bool
{
    if (!array_key_exists('analytics_consent', $_COOKIE)) {
        return true;
    }
    return !in_array(
        strtolower((string) $_COOKIE['analytics_consent']),
        ['0', 'false', 'no', '拒否'],
        true
    );
}

function analytics_url(?string $url): string
{
    $url = trim((string) $url);
    if ($url === '') {
        return '/';
    }
    $path = parse_url($url, PHP_URL_PATH) ?: '/';
    $host = parse_url($url, PHP_URL_HOST);
    $scheme = parse_url($url, PHP_URL_SCHEME);
    $query = parse_url($url, PHP_URL_QUERY);
    $safe = [];
    if ($query) {
        parse_str($query, $params);
        foreach (
            [
                'utm_source',
                'utm_medium',
                'utm_campaign',
                'utm_term',
                'utm_content',
            ]
            as $key
        ) {
            if (isset($params[$key]) && is_scalar($params[$key])) {
                $safe[$key] = substr((string) $params[$key], 0, 150);
            }
        }
    }
    $prefix =
        $host && in_array(strtolower((string) $scheme), ['http', 'https'], true)
            ? strtolower((string) $scheme) . '://' . strtolower($host)
            : '';
    return substr(
        $prefix . $path . ($safe ? '?' . http_build_query($safe) : ''),
        0,
        512
    );
}

function analytics_user_agent(string $ua): array
{
    $device = preg_match('/bot|crawler|spider|slurp/i', $ua)
        ? 'bot'
        : (preg_match('/ipad|tablet/i', $ua)
            ? 'tablet'
            : (preg_match('/mobile|android|iphone|ipod/i', $ua)
                ? 'mobile'
                : 'desktop'));
    $os = preg_match('/windows/i', $ua)
        ? 'Windows'
        : (preg_match('/mac os|macintosh/i', $ua)
            ? 'macOS'
            : (preg_match('/android/i', $ua)
                ? 'Android'
                : (preg_match('/iphone|ipad|ios/i', $ua)
                    ? 'iOS'
                    : (preg_match('/linux/i', $ua)
                        ? 'Linux'
                        : 'Other'))));
    $browser = preg_match('/edg/i', $ua)
        ? 'Edge'
        : (preg_match('/chrome|crios/i', $ua)
            ? 'Chrome'
            : (preg_match('/firefox|fxios/i', $ua)
                ? 'Firefox'
                : (preg_match('/safari/i', $ua)
                    ? 'Safari'
                    : (preg_match('/opr|opera/i', $ua)
                        ? 'Opera'
                        : 'Other'))));
    return [$device, $os, $browser];
}

function analytics_country(): ?string
{
    $country = strtoupper(
        (string) ($_SERVER['HTTP_CF_IPCOUNTRY'] ??
            ($_SERVER['HTTP_X_COUNTRY_CODE'] ?? ''))
    );
    if (preg_match('/^[A-Z]{2}$/', $country)) {
        return $country;
    }
    $language = strtolower(
        substr((string) ($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? ''), 0, 2)
    );
    return [
        'fr' => 'FR',
        'en' => 'US',
        'de' => 'DE',
        'es' => 'ES',
        'it' => 'IT',
        'nl' => 'NL',
        'pt' => 'PT',
        'be' => 'BE',
        'ch' => 'CH',
    ][$language] ?? null;
}

function analytics_cookie(string $name, string $value, int $expires): void
{
    if (!headers_sent()) {
        setcookie($name, $value, [
            'expires' => $expires,
            'path' => '/',
            'secure' => !empty($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
}

function analytics_session(PDO $pdo, ?array $client = null): ?array
{
    if (!analytics_allowed()) {
        return null;
    }
    $client = is_array($client) ? $client : [];
    $now = time();
    $sessionKey = (string) ($_COOKIE['analytics_session'] ?? '');
    $visitorCookie = (string) ($_COOKIE['analytics_visitor'] ?? '');
    $secret =
        (string) (getenv('ANALYTICS_SECRET') ?: 'change-this-analytics-secret');
    if (!preg_match('/^[a-f0-9-]{36}$/i', $sessionKey)) {
        $sessionKey = analytics_uuid_v4();
        analytics_cookie('analytics_session', $sessionKey, $now + 31536000);
    }
    if (!preg_match('/^[a-f0-9-]{36}$/i', $visitorCookie)) {
        $visitorCookie = analytics_uuid_v4();
        analytics_cookie('analytics_visitor', $visitorCookie, $now + 63072000);
    }
    $visitorKey = hash_hmac('sha256', $visitorCookie, $secret);
    $url = analytics_url(
        (string) ($client['page_url'] ?? ($_SERVER['REQUEST_URI'] ?? '/'))
    );
    $referrer = analytics_url(
        (string) ($client['referrer_url'] ?? ($_SERVER['HTTP_REFERER'] ?? ''))
    );
    $host =
        parse_url((string) ($_SERVER['HTTP_REFERER'] ?? ''), PHP_URL_HOST) ?:
            null;
    [$device, $os, $browser] = analytics_user_agent(
        (string) ($_SERVER['HTTP_USER_AGENT'] ?? '')
    );
    $timeout = 1800;
    try {
        $find = $pdo->prepare(
            'SELECT id, last_seen_at, visitor_key FROM analytics_sessions WHERE session_key = ? LIMIT 1'
        );
        $find->execute([$sessionKey]);
        $existing = $find->fetch(PDO::FETCH_ASSOC);
        $new =
            !$existing ||
            (strtotime((string) $existing['last_seen_at']) ?: 0) <
            $now - $timeout;
        if ($new) {
            if ($existing) {
                $sessionKey = analytics_uuid_v4();
                analytics_cookie(
                    'analytics_session',
                    $sessionKey,
                    $now + 31536000
                );
            }
            $returnStmt = $pdo->prepare(
                'SELECT 1 FROM analytics_sessions WHERE visitor_key = ? LIMIT 1'
            );
            $returnStmt->execute([$visitorKey]);
            $returning = (int) (bool) $returnStmt->fetchColumn();
            $stmt = $pdo->prepare(
                'INSERT INTO analytics_sessions (session_key, visitor_key, entry_url, landing_page, referrer_url, referrer_host, utm_source, utm_medium, utm_campaign, utm_term, utm_content, country_code, language, device_type, os_name, browser_name, started_at, last_seen_at, event_count, page_view_count, is_returning, consent_analytics) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), 0, 0, ?, 1)'
            );
            $stmt->execute([
                $sessionKey,
                $visitorKey,
                $url,
                $url,
                $referrer ?: null,
                $host,
                $client['utm_source'] ?? null,
                $client['utm_medium'] ?? null,
                $client['utm_campaign'] ?? null,
                $client['utm_term'] ?? null,
                $client['utm_content'] ?? null,
                analytics_country(),
                substr(
                    (string) ($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? ''),
                    0,
                    16
                ) ?:
                    null,
                $device,
                $os,
                $browser,
                $returning,
            ]);
        } else {
            $stmt = $pdo->prepare(
                'UPDATE analytics_sessions SET last_seen_at=NOW(), exit_url=?, screen_width=COALESCE(?, screen_width), screen_height=COALESCE(?, screen_height) WHERE session_key=?'
            );
            $stmt->execute([
                $url,
                $client['screen_width'] ?? null,
                $client['screen_height'] ?? null,
                $sessionKey,
            ]);
        }
        $id = $pdo->prepare(
            'SELECT id FROM analytics_sessions WHERE session_key = ?'
        );
        $id->execute([$sessionKey]);
        return ['id' => $id->fetchColumn(), 'key' => $sessionKey];
    } catch (Throwable $e) {
        analytics_log_error($e);
        return null;
    }
}

function analytics_event(
    PDO $pdo,
    ?array $session,
    string $type,
    array $payload = []
): bool {
    if (!$session || !analytics_allowed()) {
        return false;
    }
    try {
        $metadata = $payload['metadata'] ?? null;
        $metadataJson =
            $metadata === null
                ? null
                : json_encode(
                is_array($metadata)
                    ? array_slice($metadata, 0, 30, true)
                    : ['value' => (string) $metadata],
                JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
            );
        $stmt = $pdo->prepare(
            'INSERT INTO analytics_events (session_id, event_key, event_type, page_url, page_title, target_type, target_id, target_label, value_number, value_text, metadata_json, occurred_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())'
        );
        $stmt->execute([
            $session['id'],
            analytics_uuid_v4(),
            substr(preg_replace('/[^a-z0-9_.:-]/i', '', $type), 0, 50) ?:
                'custom',
            analytics_url(
                $payload['page_url'] ?? ($_SERVER['REQUEST_URI'] ?? '/')
            ),
            substr((string) ($payload['page_title'] ?? ''), 0, 255) ?: null,
            substr((string) ($payload['target_type'] ?? ''), 0, 50) ?: null,
            substr((string) ($payload['target_id'] ?? ''), 0, 191) ?: null,
            substr((string) ($payload['target_label'] ?? ''), 0, 255) ?: null,
            is_numeric($payload['value_number'] ?? null)
                ? (float) $payload['value_number']
                : null,
            substr((string) ($payload['value_text'] ?? ''), 0, 255) ?: null,
            $metadataJson,
        ]);
        $pdo->prepare(
            'UPDATE analytics_sessions SET event_count=event_count+1, page_view_count=page_view_count+? WHERE id=?'
        )->execute([$type === 'page_view' ? 1 : 0, $session['id']]);
        return true;
    } catch (Throwable $e) {
        analytics_log_error($e);
        return false;
    }

    function analytics_interaction(
        PDO $pdo,
        ?array $session,
        string $type,
        array $payload = []
    ): bool {
        return analytics_event($pdo, $session, $type, $payload);
    }

    function analytics_performance(
        PDO $pdo,
        ?array $session,
        array $payload
    ): bool {
        if (!$session || !analytics_allowed()) {
            return false;
        }
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO analytics_performance (session_id, page_url, connection_type, navigation_type, ttfb_ms, fcp_ms, lcp_ms, cls, inp_ms, dom_ready_ms, load_complete_ms, recorded_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())'
            );
            $int = static function ($value): ?int {
                return is_numeric($value)
                    ? max(0, min((int) $value, 86400000))
                    : null;
            };
            $decimal = static function ($value): ?float {
                return is_numeric($value)
                    ? max(0, min((float) $value, 1000))
                    : null;
            };
            $stmt->execute([
                $session['id'],
                analytics_url(
                    $payload['page_url'] ?? ($_SERVER['REQUEST_URI'] ?? '/')
                ),
                substr((string) ($payload['connection_type'] ?? ''), 0, 30) ?:
                    null,
                substr((string) ($payload['navigation_type'] ?? ''), 0, 30) ?:
                    null,
                $int($payload['ttfb_ms'] ?? null),
                $int($payload['fcp_ms'] ?? null),
                $int($payload['lcp_ms'] ?? null),
                $decimal($payload['cls'] ?? null),
                $int($payload['inp_ms'] ?? null),
                $int($payload['dom_ready_ms'] ?? null),
                $int($payload['load_complete_ms'] ?? null),
            ]);
            return true;
        } catch (Throwable $e) {
            analytics_log_error($e);
            return false;
        }
    }
}

function analytics_update_duration(
    PDO $pdo,
    ?array $session,
    int $seconds,
    ?string $exitUrl = null
): void {
    if (!$session) {
        return;
    }
    try {
        $pdo->prepare(
            'UPDATE analytics_sessions SET duration_seconds=?, ended_at=NOW(), exit_url=COALESCE(?, exit_url), last_seen_at=NOW() WHERE id=?'
        )->execute([
            max(0, min($seconds, 86400)),
            $exitUrl ? analytics_url($exitUrl) : null,
            $session['id'],
        ]);
    } catch (Throwable $e) {
        analytics_log_error($e);
    }
}
