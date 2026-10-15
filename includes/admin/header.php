<?php
    $asset_version = static function (string $path): string {
        $file = __DIR__ . '/../../' . $path;
        return is_file($file) ? '?v=' . filemtime($file) : '';
    };
?>
<head>

    <!-- Base metadata -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Administration — Gaston Krabansky</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.css<?= $asset_version('assets/css/style.css') ?>">
    <link rel="stylesheet" href="/assets/css/components.css<?= $asset_version('assets/css/components.css') ?>">
    <link rel="stylesheet" href="/assets/css/responsive.css<?= $asset_version('assets/css/responsive.css') ?>">
    <link rel="stylesheet" href="/assets/css/admin.css<?= $asset_version('assets/css/admin.css') ?>">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <script src="/assets/js/navigation.js<?= $asset_version('/assets/js/navigation.js') ?>" defer></script>
    <script src="/assets/js/components.js<?= $asset_version('assets/js/components.js') ?>" defer></script>
    <script src="/assets/js/admin.js<?= $asset_version('/assets/js/admin.js') ?>" defer></script>
</head>