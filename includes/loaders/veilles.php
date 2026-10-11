<?php

function getVeilleDirectory(): string
{
    return __DIR__ . '/../../content/bts-sio/veilles/';
}

function getAllVeillesData(): array
{
    $dir = getVeilleDirectory();
    $items = [];

    if (is_dir($dir)) {
        $files = glob($dir . '*.json');
        foreach ($files as $file) {
            $content = file_get_contents($file);
            $data = json_decode($content, true);
            if ($data) {
                $items[] = $data;
            }
        }
    }

    usort($items, function($a, $b) {
        return ($b['rank'] ?? 0) <=> ($a['rank'] ?? 0);
    });

    return $items;
}

function getVeilleItemById($id)
{
    $dir = getVeilleDirectory();
    $filePath = $dir . $id . '.json';

    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);
        if ($data) {
            return $data;
        }
    }

    return null;
}

function renderVeilleGridHtml(string $detailLinkBase = '/bts-sio/veilles/detail?id='): string
{
    $veilles = getAllVeillesData();

    $html = '<section class="container">' . "\n";
    $html .= '    <div class="card-grid">' . "\n\n";

    if (empty($veilles)) {
        $html .= '        <p>Aucune veille technologique pour le moment.</p>' . "\n";
    } else {
        foreach ($veilles as $veille) {
            $id = $veille['id'] ?? '';
            $fullTitle = $veille['title'] ?? '';

            $icon = 'fas fa-shield-halved';
            if (preg_match('/class=[\'"]([^\'"]+)[\'"]/', $fullTitle, $matches)) {
                $icon = $matches[1];
            }
            $cleanTitle = trim(preg_replace('/<[^>]*>[\s\S]*?<\/[^>]*>|<[^>]*>/', '', $fullTitle));
            if (empty($cleanTitle)) {
                $cleanTitle = strip_tags($fullTitle);
            }

            $period = htmlspecialchars($veille['meta']['period'] ?? '', ENT_QUOTES, 'UTF-8');

            $summary = '';
            if (isset($veille['sections']) && is_array($veille['sections'])) {
                foreach ($veille['sections'] as $sec) {
                    if (($sec['type'] ?? '') === 'text' && !empty($sec['description'])) {
                        $summary = htmlspecialchars($sec['description'], ENT_QUOTES, 'UTF-8');
                        break;
                    }
                }
            }

            $url = $detailLinkBase . $id;

            $html .= '        <a href="' . $url . '" class="item-card" style="text-decoration:none; padding:30px;">' . "\n";
            $html .= '            <div class="item-body" style="padding:0;">' . "\n";
            $html .= '                <h3><i class="' . $icon . '" style="color:var(--main-color);"></i></h3>' . "\n";
            $html .= '                <h3 style="margin-top:10px;">' . htmlspecialchars($cleanTitle, ENT_QUOTES, 'UTF-8') . '</h3>' . "\n";
            if ($period) {
                $html .= '                <span class="item-date" style="margin-bottom:10px; display:block;">' . $period . '</span>' . "\n";
            }
            if ($summary) {
                $html .= '                <p>' . $summary . '</p>' . "\n";
            }
            $html .= '                <span class="item-link">Lire la veille <i class="fas fa-arrow-right"></i></span>' . "\n";
            $html .= '            </div>' . "\n";
            $html .= '        </a>' . "\n";
        }
    }

    $html .= '    </div>' . "\n";
    $html .= '</section>';

    return $html;
}

function renderVeilleDetailHtml($item): string
{
    if (!$item) {
        $html = '<section class="container">' . "\n";
        $html .= '    <a href="/bts-sio/veilles" class="back-link"><i class="fas fa-arrow-left"></i> Retour aux veilles</a>' . "\n\n";
        $html .= '    <div class="detail-content" style="text-align: center; padding: 40px 0;">' . "\n";
        $html .= '        <h1>Oups ! Veille introuvable</h1>' . "\n";
        $html .= '        <p style="margin: 20px 0;">La veille technologique que vous recherchez n\'existe pas ou a été supprimée.</p>' . "\n";
        $html .= '        <a href="/bts-sio/veilles" class="btn btn-fill" style="display: inline-block; margin-top: 15px;">Retourner aux veilles <i class="fas fa-arrow-right"></i></a>' . "\n";
        $html .= '    </div>' . "\n";
        $html .= '</section>';
        return $html;
    }

    $title = $item['title'] ?? '';
    $period = htmlspecialchars($item['meta']['period'] ?? '', ENT_QUOTES, 'UTF-8');

    $html = '<section class="container">' . "\n";
    $html .= '    <a href="/bts-sio/veilles" class="back-link"><i class="fas fa-arrow-left"></i> Retour aux veilles</a>' . "\n\n";
    $html .= '    <div class="detail-content">' . "\n";
    $html .= '        <h1>' . $title . '</h1>' . "\n";

    if ($period) {
        $html .= '        <div class="detail-meta">' . "\n";
        $html .= '            <span class="stat-tag">' . $period . '</span>' . "\n";
    }
    $html .= '        </div>' . "\n\n";

    $formatTextWithLinks = function($text) {
        $safeText = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        $pattern = '/\[([^\]]+)\]\((https?:\/\/[^\s)]+)\)/';

        return preg_replace_callback($pattern, function($matches) {
            return '<a href="' . htmlspecialchars($matches[2], ENT_QUOTES, 'UTF-8') . '" target="_blank" rel="noopener noreferrer">' . htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8') . '</a>';
        }, $safeText);
    };

    if (isset($item['sections']) && is_array($item['sections'])) {
        foreach ($item['sections'] as $section) {
            $type = $section['type'] ?? 'text';
            $sectionTitle = $section['title'] ?? '';

            if ($type === 'text') {
                if (!empty($sectionTitle)) {
                    $html .= '        <h2>' . htmlspecialchars($sectionTitle, ENT_QUOTES, 'UTF-8') . '</h2>' . "\n";
                }
                if (!empty($section['description'])) {
                    $html .= '        <p>' . $formatTextWithLinks($section['description']) . '</p>' . "\n\n";
                }
            }
            elseif ($type === 'list') {
                if (!empty($sectionTitle)) {
                    $html .= '        <h2>' . htmlspecialchars($sectionTitle, ENT_QUOTES, 'UTF-8') . '</h2>' . "\n";
                }
                if (!empty($section['elements']) && is_array($section['elements'])) {
                    $html .= '        <ul>' . "\n";
                    foreach ($section['elements'] as $element) {
                        $html .= '            <li>' . $formatTextWithLinks($element) . '</li>' . "\n";
                    }
                    $html .= '        </ul>' . "\n\n";
                }
            }
        }
    }

    $html .= '    </div>' . "\n";
    $html .= '</section>';

    return $html;
}