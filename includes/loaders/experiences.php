<?php

function getDirectoryByType($type): string
{
    $baseDir = __DIR__ . '/../../content/experiences/';

    if ($type === 'professionnel') {
        return $baseDir . 'professionnel/';
    }

    return $baseDir . 'scolaire/';
}

function getParcoursDataByType($type = 'scolaire'): array
{
    $dir = getDirectoryByType($type);
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

function getParcoursItemById($id, $type = null) {
    $typesToSearch = $type ? [$type] : ['scolaire', 'professionnel'];

    foreach ($typesToSearch as $t) {
        $dir = getDirectoryByType($t);
        $filePath = $dir . $id . '.json';

        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
            $data = json_decode($content, true);
            if ($data) {
                $data['category'] = $t;
                return $data;
            }
        }
    }

    return null;
}

function renderParcoursDetailHtml($item): string
{
    if (!$item) {
        $html = '<section class="container">' . "\n";
        $html .= '    <a href="/experiences" class="back-link"><i class="fas fa-arrow-left"></i> Retour aux expériences</a>' . "\n\n";
        $html .= '    <div class="detail-content" style="text-align: center; padding: 40px 0;">' . "\n";
        $html .= '        <h1>Oups ! Élément introuvable</h1>' . "\n";
        $html .= '        <p style="margin: 20px 0;">La formation ou l\'expérience que vous recherchez n\'existe pas ou a été déplacée.</p>' . "\n";
        $html .= '    </div>' . "\n";
        $html .= '</section>';
        return $html;
    }

    $title = htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8');
    $period = htmlspecialchars($item['meta']['period'] ?? '', ENT_QUOTES, 'UTF-8');
    $location = htmlspecialchars($item['meta']['location'] ?? '', ENT_QUOTES, 'UTF-8');
    $summary = htmlspecialchars($item['summary'] ?? '', ENT_QUOTES, 'UTF-8');

    $html = '<section class="container">' . "\n";
    $html .= '    <a href="/experiences" class="back-link"><i class="fas fa-arrow-left"></i> Retour aux expériences</a>' . "\n\n";
    $html .= '    <div class="detail-content">' . "\n";
    $html .= '        <h1>' . $title . '</h1>' . "\n";
    $html .= '        <div class="detail-meta">' . "\n";
    if ($period) {
        $html .= '            <span class="stat-tag">' . $period . '</span>' . "\n";
    }
    if ($location) {
        $html .= '            <span class="stat-tag">' . $location . '</span>' . "\n";
    }
    $html .= '        </div>' . "\n\n";

    if ($summary) {
        $html .= '        <p>' . $summary . '</p>' . "\n\n";
    }

    if (isset($item['sections']) && is_array($item['sections'])) {
        foreach ($item['sections'] as $section) {
            $type = $section['type'] ?? 'text';
            $sectionTitle = $section['title'] ?? '';

            if ($type === 'text') {
                if (!empty($sectionTitle)) {
                    $html .= '        <h2>' . $sectionTitle . '</h2>' . "\n";
                }
                $html .= '        <p>' . ($section['description'] ?? '') . '</p>' . "\n\n";
            }
            elseif ($type === 'list') {
                if (!empty($sectionTitle)) {
                    $html .= '        <h2>' . $sectionTitle . '</h2>' . "\n";
                }
                if (!empty($section['description'])) {
                    $html .= '        <p>' . $section['description'] . '</p>' . "\n";
                }
                if (!empty($section['elements'])) {
                    $html .= '        <ul>' . "\n";
                    foreach ($section['elements'] as $element) {
                        $html .= '            <li>' . htmlspecialchars($element, ENT_QUOTES, 'UTF-8') . '</li>' . "\n";
                    }
                    $html .= '        </ul>' . "\n\n";
                }
            }
            elseif ($type === 'block') {
                $block = $section['block'] ?? [];
                $html .= '        <div class="info-block">' . "\n";
                if (!empty($block['title'])) {
                    $html .= '            <h3>' . $block['title'] . '</h3>' . "\n";
                }
                if (!empty($block['description'])) {
                    $html .= '            <p style="margin-bottom:15px;">' . $block['description'] . '</p>' . "\n";
                }
                if (!empty($block['link'])) {
                    $html .= '            <a href="' . htmlspecialchars($block['link']['url'], ENT_QUOTES, 'UTF-8') . '" class="btn btn-fill">' . $block['link']['label'] . '</a>' . "\n";
                }
                $html .= '        </div>' . "\n\n";
            }
            elseif ($type === 'document') {
                $html .= '        <div class="info-block">' . "\n";
                if (!empty($section['title'])) {
                    $html .= '            <h3>' . $section['title'] . '</h3>' . "\n";
                }
                if (!empty($section['description'])) {
                    $html .= '            <p style="margin-bottom:15px;">' . $section['description'] . '</p>' . "\n";
                }
                if (!empty($section['path'])) {
                    $html .= '            <a href="' . htmlspecialchars($section['path'], ENT_QUOTES, 'UTF-8') . '" class="btn btn-fill" target="_blank"><i class="fas fa-download"></i> Télécharger le document</a>' . "\n";
                }
                $html .= '        </div>' . "\n\n";
            }
        }
    }

    $html .= '    </div>' . "\n";
    $html .= '</section>';

    return $html;
}

function renderParcoursTimelineHtml(string $basePath = '/experiences/'): string
{
    $proItems = getParcoursDataByType('professionnel');
    $scolaireItems = getParcoursDataByType('scolaire');

    $html = '<section class="container">' . "\n";
    $html .= '    <div class="tab-buttons">' . "\n";
    $html .= '        <button class="tab-btn active" data-target="#pro">Professionnel</button>' . "\n";
    $html .= '        <button class="tab-btn" data-target="#edu">Scolaire</button>' . "\n";
    $html .= '    </div>' . "\n\n";

    // --- PROFESSIONAL TAB ---
    $html .= '    <div class="tab-content active-content" id="pro">' . "\n";
    $html .= '        <div class="timeline">' . "\n";
    if (empty($proItems)) {
        $html .= '            <p style="padding: 20px;">Aucune expérience professionnelle pour le moment.</p>' . "\n";
    } else {
        foreach ($proItems as $item) {
            $html .= renderTimelineItem($item, $basePath);
        }
    }
    $html .= '        </div>' . "\n";
    $html .= '    </div>' . "\n\n";

    // --- SCHOOL TAB ---
    $html .= '    <div class="tab-content" id="edu">' . "\n";
    $html .= '        <div class="timeline">' . "\n";
    if (empty($scolaireItems)) {
        $html .= '            <p style="padding: 20px;">Aucune formation scolaire pour le moment.</p>' . "\n";
    } else {
        foreach ($scolaireItems as $item) {
            $html .= renderTimelineItem($item, $basePath);
        }
    }
    $html .= '        </div>' . "\n";
    $html .= '    </div>' . "\n";
    $html .= '</section>';

    return $html;
}

function renderTimelineItem($item, $basePath): string
{
    $id = $item['id'] ?? '';
    $title = htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8');
    $period = htmlspecialchars($item['meta']['period'] ?? '', ENT_QUOTES, 'UTF-8');
    $summary = htmlspecialchars($item['summary'] ?? '', ENT_QUOTES, 'UTF-8');

    $detailLink = $basePath . ($item['category'] ?? 'scolaire') . '/' . $id;

    $html = '            <div class="timeline-item">' . "\n";
    $html .= '                <h3><a href="' . $detailLink . '">' . $title . '</a></h3>' . "\n";
    if ($period) {
        $html .= '                <span class="date">' . $period . '</span>' . "\n";
    }
    if ($summary) {
        $html .= '                <p>' . $summary . '</p>' . "\n";
    }

    $html .= '                <div class="timeline-actions">' . "\n";
    $html .= '                    <a href="' . $detailLink . '" class="btn btn-outline sm">En savoir plus <i class="fas fa-arrow-right"></i></a>' . "\n";

    if (isset($item['sections']) && is_array($item['sections'])) {
        foreach ($item['sections'] as $section) {
            if (($section['type'] ?? '') === 'block' && isset($section['block']['link'])) {
                $linkData = $section['block']['link'];
                $url = htmlspecialchars($linkData['url'] ?? '#', ENT_QUOTES, 'UTF-8');
                $html .= '                    <a href="' . $url . '" class="btn btn-fill sm">Voir la section BTS SIO <i class="fas fa-school"></i></a>' . "\n";
            }
        }
    }

    $html .= '                </div>' . "\n";
    $html .= '            </div>' . "\n";

    return $html;
}