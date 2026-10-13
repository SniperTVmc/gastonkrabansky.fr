<?php

function get_seo_data($page_key, $custom_overrides = []): array
{
    $base_url = 'https://gastonkrabansky.fr';
    $default_image = $base_url . '/assets/images/profile/photo.webp';

    $pages = [
        'accueil' => [
            'title' => 'Gaston Krabansky — Développeur & Étudiant à Lille',
            'description' => 'Portfolio officiel de Gaston Krabansky, étudiant en BTS SIO option SLAM et développeur à Lille. Découvrez mes projets, compétences et réalisations.',
            'canonical' => $base_url . '/',
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_image' => $default_image,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'ProfilePage',
                'mainEntity' => [
                    '@type' => 'Person',
                    'name' => 'Gaston Krabansky',
                    'jobTitle' => 'Développeur Junior & Étudiant BTS SIO SLAM',
                    'url' => $base_url,
                    'address' => [
                        '@type' => 'PostalAddress',
                        'addressLocality' => 'Lille',
                        'addressRegion' => 'Hauts-de-France',
                        'addressCountry' => 'FR'
                    ],
                    'sameAs' => [
                        'https://github.com/SniperTVmc/',
                        'https://www.linkedin.com/in/gaston-krabansky/'
                    ]
                ]
            ]
        ],
        'competences' => [
            'title' => 'Compétences & Stack Technique — Gaston Krabansky',
            'description' => 'Explorez les compétences techniques de Gaston Krabansky : Java, Python, Linux, SQL, Docker, administration système et développement backend.',
            'canonical' => $base_url . '/competences',
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_image' => $default_image,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Compétences Techniques',
                'description' => 'Stack technique et compétences en développement de Gaston Krabansky.'
            ]
        ],
        'experiences' => [
            'title' => 'Expériences Professionnelles — Gaston Krabansky',
            'description' => 'Découvrez le parcours professionnel et les expériences de Gaston Krabansky en développement backend et administration système.',
            'canonical' => $base_url . '/experiences',
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_image' => $default_image,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'ProfilePage',
                'name' => 'Expériences Professionnelles'
            ]
        ],
        'projets' => [
            'title' => 'Projets & Réalisations — Gaston Krabansky',
            'description' => 'Découvrez les projets de développement Java, plugins Minecraft open source et réalisations académiques en BTS SIO SLAM de Gaston Krabansky.',
            'canonical' => $base_url . '/projets',
            'robots' => 'index, follow',
            'og_type' => 'collectionpage',
            'og_image' => $default_image,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Projets et Open Source',
                'description' => 'Liste des projets et réalisations open source de Gaston Krabansky.'
            ]
        ],
        'cv' => [
            'title' => 'CV de Gaston Krabansky — Développeur Java (Lille)',
            'description' => 'Consultez et téléchargez le CV officiel de Gaston Krabansky, développeur Java junior et étudiant en BTS SIO option SLAM basé à Lille.',
            'canonical' => $base_url . '/cv',
            'robots' => 'index, follow',
            'og_type' => 'profile',
            'og_image' => $default_image,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'ProfilePage',
                'name' => 'Curriculum Vitæ — Gaston Krabansky'
            ]
        ],
        'contact' => [
            'title' => 'Contact — Gaston Krabansky',
            'description' => 'Contactez Gaston Krabansky, développeur Java junior et étudiant en BTS SIO option SLAM à Lille, pour toute opportunité professionnelle ou échange.',
            'canonical' => $base_url . '/contact',
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_image' => $default_image,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'ContactPage',
                'name' => 'Contact'
            ]
        ],
        'mentions_legales' => [
            'title' => 'Mentions légales — Gaston Krabansky',
            'description' => 'Mentions légales du site gastonkrabansky.fr : éditeur, hébergement, propriété intellectuelle et responsabilités.',
            'canonical' => $base_url . '/mentions-legales',
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_image' => $default_image,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Mentions légales'
            ]
        ],
        'politique_confidentialite' => [
            'title' => 'Politique de confidentialité — Gaston Krabansky',
            'description' => 'Politique de confidentialité du site gastonkrabansky.fr et informations sur le traitement des données personnelles.',
            'canonical' => $base_url . '/politique-de-confidentialite',
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_image' => $default_image,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Politique de confidentialité'
            ]
        ],
        'politique_cookies' => [
            'title' => 'Politique cookies — Gaston Krabansky',
            'description' => 'Politique relative aux cookies et traceurs utilisés par le site gastonkrabansky.fr.',
            'canonical' => $base_url . '/politique-cookies',
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_image' => $default_image,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Politique cookies'
            ]
        ],
        'bts_presentation' => [
            'title' => 'Le BTS SIO SLAM — Présentation & Programme',
            'description' => 'Présentation détaillée de mon parcours en BTS SIO option SLAM (Solutions Logicielles et Applications Métiers) à Lille.',
            'canonical' => $base_url . '/bts-sio',
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_image' => $default_image,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Présentation du BTS SIO SLAM'
            ]
        ],
        'bts_realisations' => [
            'title' => 'Réalisations BTS SIO SLAM — Gaston Krabansky',
            'description' => 'Portfolio des réalisations professionnelles et académiques réalisées dans le cadre du BTS SIO option SLAM.',
            'canonical' => $base_url . '/bts-sio/realisations',
            'robots' => 'index, follow',
            'og_type' => 'collectionpage',
            'og_image' => $default_image,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Réalisations BTS SIO SLAM'
            ]
        ],
        'veilles' => [
            'title' => 'Veilles Technologiques — BTS SIO',
            'description' => 'Veilles technologiques menées dans le cadre du BTS SIO : analyses, tendances et actualités autour de Java, Linux et du développement.',
            'canonical' => $base_url . '/bts-sio/veilles',
            'robots' => 'index, follow',
            'og_type' => 'collectionpage',
            'og_image' => $default_image,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Veilles Technologiques'
            ]
        ],
        '404' => [
            'title' => 'Page introuvable — Gaston Krabansky',
            'description' => 'La page que vous recherchez est introuvable. Retournez à l’accueil du portfolio de Gaston Krabansky.',
            'canonical' => $base_url . '/404',
            'robots' => 'noindex, nofollow',
            'og_type' => 'website',
            'og_image' => $default_image,
            'schema' => []
        ]
    ];

    $config = $pages[$page_key] ?? $pages['accueil'];

    // Application des surcharges personnalisées si fournies (ex: page de détail dynamique)
    foreach ($custom_overrides as $key => $value) {
        if (!empty($value)) {
            $config[$key] = $value;
        }
    }

    $config['description'] = trim(preg_replace('/\s+/', ' ', strip_tags($config['description'])));
    $description_length = function_exists('mb_strlen')
        ? mb_strlen($config['description'])
        : strlen($config['description']);
    if ($description_length > 160) {
        $description = function_exists('mb_substr')
            ? mb_substr($config['description'], 0, 157)
            : substr($config['description'], 0, 157);
        $config['description'] = rtrim($description, " \t\n\r\0\x0B.,;:") . '...';
    }

    if (!empty($config['og_image']) && strpos($config['og_image'], 'http') !== 0) {
        $image_path = preg_replace('#^(?:\.\./)+#', '', $config['og_image']);
        $config['og_image'] = $base_url . '/' . ltrim($image_path, '/');
    }

    return $config;
}