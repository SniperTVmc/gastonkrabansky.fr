<?php
    if (!function_exists("get_seo_data")) {
        require_once(__DIR__ . "/seo.php");
    }
    $current_page_key = $page_seo_key ?? 'accueil';
    $page_custom = $page_seo_custom ?? [];
    $seo = get_seo_data($current_page_key, $page_custom);
?>
<head>

    <!-- Base Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($seo['title'], ENT_QUOTES, 'UTF-8'); ?></title>

    <!-- Dynamic SEO Meta Tags -->
    <meta name="description" content="<?php echo htmlspecialchars($seo['description'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="author" content="Gaston Krabansky">
    <meta name="robots" content="<?php echo htmlspecialchars($seo['robots'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="color-scheme" content="dark">
    <meta name="theme-color" content="#df9b67">
    <link rel="canonical" href="<?php echo htmlspecialchars($seo['canonical'], ENT_QUOTES, 'UTF-8'); ?>">

    <!-- DNS Prefetch & Preconnect -->
    <link rel="dns-prefetch" href="https://avatars.githubusercontent.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Open Graph / Scocial Media Meta Tags -->
    <meta property="og:locale" content="fr_FR">
    <meta property="og:type" content="<?php echo htmlspecialchars($seo['og_type'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($seo['title'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($seo['description'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($seo['canonical'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($seo['og_image'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image:alt" content="<?php echo htmlspecialchars($seo['title'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:site_name" content="Gaston Krabansky — Portfolio">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($seo['title'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($seo['description'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($seo['og_image'], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:image:alt" content="<?php echo htmlspecialchars($seo['title'], ENT_QUOTES, 'UTF-8'); ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/assets/images/favicon/site.webmanifest" />

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Humans.txt & AI Summary -->
    <link type="text/plain" rel="author" href="/humans.txt">
    <link rel="help" type="text/markdown" title="AI Summary" href="/llms.txt">

    <!-- Structured Data (JSON-LD) -->
    <?php if (!empty($seo['schema'])): ?>
        <script type="application/ld+json">
    <?php echo json_encode($seo['schema'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>
    </script>
    <?php endif; ?>

    <!-- Scripts (defer : exécutés après le chargement du DOM) -->
    <script src="/assets/js/main.js" defer></script>
    <script src="/assets/js/navigation.js" defer></script>
    <script src="/assets/js/components.js" defer></script>

</head>