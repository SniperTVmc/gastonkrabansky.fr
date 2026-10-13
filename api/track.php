<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../includes/analytics.php';

$respond = static function (bool $ok, int $status = 200): void {
    http_response_code($status);
    echo json_encode(['status' => $ok ? 'success' : 'error']);
    exit();
};
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !analytics_allowed()) {
    $respond(false, 204);
}
try {
    require_once __DIR__ . '/../includes/database.php';
    $raw = json_decode(file_get_contents('php://input'), true);
    $data = is_array($raw) ? $raw : $_POST;
    $type =
        (string) ($data['event_type'] ?? ($data['action_type'] ?? 'custom'));
    $metadata = $data['metadata'] ?? [];
    if (!is_array($metadata)) {
        $metadata = ['value' => (string) $metadata];
    }
    $session = analytics_session($pdo, [
        'page_url' => $data['page_url'] ?? ($_SERVER['HTTP_REFERER'] ?? '/'),
        'screen_width' => filter_var(
            $data['screen_width'] ?? null,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1, 'max_range' => 10000]]
        ),
        'screen_height' => filter_var(
            $data['screen_height'] ?? null,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1, 'max_range' => 10000]]
        ),
    ]);
    if (in_array($type, ['duration', 'session_end'], true)) {
        analytics_update_duration(
            $pdo,
            $session,
            (int) ($data['duration_seconds'] ?? 0),
            $data['page_url'] ?? null
        );
        $respond(true);
    }
    if ($type === 'performance_measure') {
        $analytics = analytics_performance($pdo, $session, [
            'page_url' => $data['page_url'] ?? null,
            'connection_type' => $data['connection_type'] ?? null,
            'navigation_type' => $data['navigation_type'] ?? null,
            'ttfb_ms' => $data['ttfb_ms'] ?? null,
            'fcp_ms' => $data['fcp_ms'] ?? null,
            'lcp_ms' => $data['lcp_ms'] ?? null,
            'cls' => $data['cls'] ?? null,
            'inp_ms' => $data['inp_ms'] ?? null,
            'dom_ready_ms' => $data['dom_ready_ms'] ?? null,
            'load_complete_ms' => $data['load_complete_ms'] ?? null,
        ]);
        $respond($analytics);
    }
    $ok = analytics_event($pdo, $session, $type, [
        'target_type' => $data['target_type'] ?? null,
        'target_id' => $data['target_id'] ?? null,
        'target_label' =>
            $data['target_label'] ?? ($data['target_detail'] ?? null),
        'value_number' => $data['value_number'] ?? null,
        'value_text' => $data['value_text'] ?? null,
        'metadata' => $metadata,
        'page_url' => $data['page_url'] ?? null,
    ]);
    if (!$ok) {
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
            $legacy = $pdo->prepare(
                'INSERT INTO site_visits (ip_hash, page_url, action_type, target_detail, device_type) VALUES (?, ?, ?, ?, ?)'
            );
            $legacy->execute([
                $legacyHash,
                analytics_url(
                    (string) ($data['page_url'] ??
                        ($_SERVER['HTTP_REFERER'] ?? '/'))
                ),
                substr($type, 0, 50),
                is_scalar(
                    $data['target_label'] ?? ($data['target_detail'] ?? null)
                )
                    ? substr(
                    (string) ($data['target_label'] ??
                        $data['target_detail']),
                    0,
                    255
                )
                    : null,
                $device,
            ]);
            $ok = true;
        } catch (Throwable $legacyError) {
            analytics_log_error($legacyError);
        }
    }
    $respond($ok, $ok ? 200 : 503);
} catch (Throwable $e) {
    analytics_log_error($e);
    $respond(false, 503);
}
