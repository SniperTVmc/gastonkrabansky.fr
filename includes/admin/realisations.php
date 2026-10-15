<?php

function adminRealisationDirectory(): string
{
    return __DIR__ . '/../../content/bts-sio/realisations/';
}

function adminRealisationIsValidId(string $id): bool
{
    return (bool) preg_match('/^[a-z0-9][a-z0-9-]*$/', $id);
}

function adminLoadRealisations(): array
{
    $items = [];
    foreach (glob(adminRealisationDirectory() . '*.json') ?: [] as $file) {
        $data = json_decode((string) file_get_contents($file), true);
        if (is_array($data)) {
            $items[] = $data;
        }
    }

    usort($items, static fn(array $a, array $b): int => ($a['rank'] ?? 0) <=> ($b['rank'] ?? 0));
    return $items;
}

function adminLoadRealisation(string $id): ?array
{
    if (!adminRealisationIsValidId($id)) {
        return null;
    }

    $file = adminRealisationDirectory() . $id . '.json';
    if (!is_file($file)) {
        return null;
    }

    $data = json_decode((string) file_get_contents($file), true);
    return is_array($data) ? $data : null;
}

function adminSaveRealisation(string $id, array $data): bool
{
    if (!adminRealisationIsValidId($id)) {
        return false;
    }

    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }

    return file_put_contents(adminRealisationDirectory() . $id . '.json', $json . PHP_EOL, LOCK_EX) !== false;
}

function adminDeleteRealisation(string $id): bool
{
    if (!adminRealisationIsValidId($id)) {
        return false;
    }

    $file = adminRealisationDirectory() . $id . '.json';
    return is_file($file) && unlink($file);
}

function adminPeriodDateValues(string $period): array
{
    preg_match_all('/\d{1,2}\/\d{1,2}\/\d{4}/', $period, $matches);
    $dates = [];
    foreach ($matches[0] as $date) {
        $parsed = DateTime::createFromFormat('d/m/Y', $date);
        $dates[] = $parsed ? $parsed->format('Y-m-d') : '';
    }

    return [$dates[0] ?? '', $dates[1] ?? date('Y-12-31')];
}

function adminFormatPeriod(string $start, string $end): string
{
    $startDate = DateTime::createFromFormat('!Y-m-d', $start);
    $endDate = DateTime::createFromFormat('!Y-m-d', $end);
    if (!$startDate || !$endDate) {
        return '';
    }

    return $startDate->format('d/m/Y') . ' → ' . $endDate->format('d/m/Y');
}

function adminFormatUpdatedAt(string $value): string
{
    $date = DateTime::createFromFormat(DateTime::ATOM, $value)
        ?: DateTime::createFromFormat('Y-m-d H:i:s', $value);
    if (!$date) {
        return $value;
    }

    $date->setTimezone(new DateTimeZone(date_default_timezone_get()));
    return $date->format('d/m/Y à H:i');
}

function adminLoadReferentiel(): array
{
    $file = __DIR__ . '/../../content/bts-sio/referentiel-sio.json';
    $data = is_file($file) ? json_decode((string) file_get_contents($file), true) : [];
    return is_array($data) ? $data : [];
}

function adminCsrfToken(): string
{
    if (empty($_SESSION['admin_csrf'])) {
        $_SESSION['admin_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['admin_csrf'];
}

function adminCheckCsrf(string $token): bool
{
    $sessionToken = (string) ($_SESSION['admin_csrf'] ?? '');
    return $sessionToken !== '' && hash_equals($sessionToken, $token);
}
