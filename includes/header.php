<?php
    if (!function_exists('get_seo_data')) {
        require_once __DIR__ . '/seo.php';
    }

    $current_page_key = $page_seo_key ?? 'accueil';
    $page_custom = $page_seo_custom ?? [];
    $seo = get_seo_data($current_page_key, $page_custom);
    $escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    $asset_version = static function (string $path): string {
        $file = __DIR__ . '/..' . $path;
        return is_file($file) ? '?v=' . filemtime($file) : '';
    };
?>
<head>

    <!-- Base metadata -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $escape($seo['title']) ?></title>

    <!-- SEO metadata -->
    <meta name="description" content="<?= $escape($seo['description']) ?>">
    <meta name="author" content="Gaston Krabansky">
    <meta name="robots" content="<?= $escape($seo['robots']) ?>">
    <meta name="color-scheme" content="dark">
    <meta name="theme-color" content="#df9b67">
    <link rel="canonical" href="<?= $escape($seo['canonical']) ?>">
    <link rel="alternate" hreflang="fr" href="<?= $escape($seo['canonical']) ?>">

    <!-- External resources -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://web3forms.com">
    <link rel="preconnect" href="https://hcaptcha.com">

    <!-- Open Graph -->
    <meta property="og:locale" content="fr_FR">
    <meta property="og:type" content="<?= $escape($seo['og_type']) ?>">
    <meta property="og:title" content="<?= $escape($seo['title']) ?>">
    <meta property="og:description" content="<?= $escape($seo['description']) ?>">
    <meta property="og:url" content="<?= $escape($seo['canonical']) ?>">
    <meta property="og:image" content="<?= $escape($seo['og_image']) ?>">
    <meta property="og:image:alt" content="<?= $escape($seo['title']) ?>">
    <meta property="og:site_name" content="Gaston Krabansky — Portfolio">

    <!-- X/Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $escape($seo['title']) ?>">
    <meta name="twitter:description" content="<?= $escape($seo['description']) ?>">
    <meta name="twitter:url" content="<?= $escape($seo['canonical']) ?>">
    <meta name="twitter:image" content="<?= $escape($seo['og_image']) ?>">
    <meta name="twitter:image:alt" content="<?= $escape($seo['title']) ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon/favicon.svg">
    <link rel="shortcut icon" href="/assets/images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon/site.webmanifest">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.css<?= $asset_version('/assets/css/style.css') ?>">
    <link rel="stylesheet" href="/assets/css/components.css<?= $asset_version('/assets/css/components.css') ?>">
    <link rel="stylesheet" href="/assets/css/responsive.css<?= $asset_version('/assets/css/responsive.css') ?>">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Site resources -->
    <link type="text/plain" rel="author" href="/humans.txt">
    <link rel="help" type="text/markdown" title="AI Summary" href="/llms.txt">

    <!-- Structured data -->
    <?php if (!empty($seo['schema'])): ?>
        <script type="application/ld+json">
            <?= json_encode($seo['schema'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>
        </script>
    <?php endif; ?>

    <!-- Scripts -->
    <script src="/assets/js/main.js<?= $asset_version('/assets/js/main.js') ?>" defer></script>
    <script src="/assets/js/navigation.js<?= $asset_version('/assets/js/navigation.js') ?>" defer></script>
    <script src="/assets/js/components.js<?= $asset_version('/assets/js/components.js') ?>" defer></script>

</head>