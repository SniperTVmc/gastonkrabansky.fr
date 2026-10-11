<?php

function getProjetsDirectory(): string
{
    return __DIR__ . '/../../content/projets/';
}

function getAllProjetsData(): array
{
    $dir = getProjetsDirectory();
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

function getProjetItemById($id)
{
    $dir = getProjetsDirectory();
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

function renderProjetDetailHtml($item): string
{
    if (!$item) {
        $html = '<section class="container">' . "\n";
        $html .= '    <a href="/projets" class="back-link"><i class="fas fa-arrow-left"></i> Retour aux projets</a>' . "\n\n";
        $html .= '    <div class="detail-content" style="text-align: center; padding: 40px 0;">' . "\n";
        $html .= '        <h1>Oups ! Projet introuvable</h1>' . "\n";
        $html .= '        <p style="margin: 20px 0;">Le projet que vous recherchez n\'existe pas ou a été supprimé.</p>' . "\n";
        $html .= '        <a href="/projets" class="btn btn-fill" style="display: inline-block; margin-top: 15px;">Retourner aux projets <i class="fas fa-arrow-right"></i></a>' . "\n";
        $html .= '    </div>' . "\n";
        $html .= '</section>';
        return $html;
    }

    $title = htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8');
    $image = htmlspecialchars($item['image'] ?? '', ENT_QUOTES, 'UTF-8');
    $imageAlt = htmlspecialchars($item['image_alt'] ?? '', ENT_QUOTES, 'UTF-8');
    $summary = $item['summary'] ?? '';

    $html = '<section class="container">' . "\n";
    $html .= '    <a href="/projets" class="back-link"><i class="fas fa-arrow-left"></i> Retour aux projets</a>' . "\n\n";

    if ($image) {
        $html .= '    <img src="' . $image . '" alt="' . $imageAlt . '" class="detail-hero-img">' . "\n\n";
    }

    $html .= '    <div class="detail-content">' . "\n";
    $html .= '        <h1>' . $title . '</h1>' . "\n";
    $html .= '        <div class="detail-meta">' . "\n";

    if (!empty($item['tech_tags'])) {
        foreach ($item['tech_tags'] as $tag) {
            $html .= '            <span class="tech-tag">' . htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') . '</span>' . "\n";
        }
    }
    if (!empty($item['stat_tags'])) {
        foreach ($item['stat_tags'] as $stat) {
            $html .= '            <span class="stat-tag">' . htmlspecialchars($stat, ENT_QUOTES, 'UTF-8') . '</span>' . "\n";
        }
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
                    $html .= '        <h2>' . htmlspecialchars($sectionTitle, ENT_QUOTES, 'UTF-8') . '</h2>' . "\n";
                }
                if (!empty($section['description'])) {
                    $html .= '        <p>' . $section['description'] . '</p>' . "\n\n";
                }
            }
            elseif ($type === 'list') {
                if (!empty($sectionTitle)) {
                    $html .= '        <h2>' . htmlspecialchars($sectionTitle, ENT_QUOTES, 'UTF-8') . '</h2>' . "\n";
                }
                if (!empty($section['elements']) && is_array($section['elements'])) {
                    $html .= '        <ul>' . "\n";
                    foreach ($section['elements'] as $element) {
                        $html .= '            <li>' . htmlspecialchars($element, ENT_QUOTES, 'UTF-8') . '</li>' . "\n";
                    }
                    $html .= '        </ul>' . "\n\n";
                }
            }
        }
    }

    if (!empty($item['links']) && is_array($item['links'])) {
        $html .= '        <div class="detail-links">' . "\n";
        foreach ($item['links'] as $link) {
            $url = htmlspecialchars($link['url'] ?? '#', ENT_QUOTES, 'UTF-8');
            $label = $link['label'] ?? '';
            $class = htmlspecialchars($link['class'] ?? 'btn btn-fill', ENT_QUOTES, 'UTF-8');
            $target = !empty($link['external']) ? ' target="_blank"' : '';

            if (isset($link['disabled']) && $link['disabled'] === true) {
                $disabledClass = str_contains(' ' . $class . ' ', ' disabled ')
                    ? $class
                    : $class . ' disabled';
                $html .= '            <span class="' . $disabledClass . '" aria-disabled="true">' . $label . '</span>' . "\n";
            } else {
                $html .= '            <a href="' . $url . '" class="' . $class . '"' . $target . '>' . $label . '</a>' . "\n";
            }
        }
        $html .= '        </div>' . "\n";
    }

    $html .= '    </div>' . "\n";
    $html .= '</section>';

    return $html;
}

function renderProjetsGridHtml(string $detailLinkBase = '/projets/detail?id='): string
{
    $projets = getAllProjetsData();

    $html = '<section class="container">' . "\n";
    $html .= '    <div class="card-grid">' . "\n\n";

    if (empty($projets)) {
        $html .= '        <p>Aucun projet pour le moment.</p>' . "\n";
    } else {
        foreach ($projets as $projet) {
            $id = $projet['id'] ?? '';
            $title = htmlspecialchars($projet['title'] ?? '', ENT_QUOTES, 'UTF-8');
            $image = htmlspecialchars($projet['image'] ?? '', ENT_QUOTES, 'UTF-8');
            $imageAlt = htmlspecialchars($projet['image_alt'] ?? '', ENT_QUOTES, 'UTF-8');
            $summary = htmlspecialchars($projet['summary'] ?? '', ENT_QUOTES, 'UTF-8');

            $date = '';
            if (!empty($projet['stat_tags']) && is_array($projet['stat_tags'])) {
                $date = htmlspecialchars($projet['stat_tags'][0], ENT_QUOTES, 'UTF-8');
            }

            $url = $detailLinkBase . $id;

            $html .= '        <div class="item-card">' . "\n";
            $html .= '            <img src="' . $image . '" alt="' . $imageAlt . '" class="item-img">' . "\n";
            $html .= '            <div class="item-body">' . "\n";
            $html .= '                <h3><span>' . $title . '</span>';
            if ($date) {
                $html .= ' <span class="item-date">' . $date . '</span>';
            }
            $html .= '</h3>' . "\n";

            if (!empty($projet['tech_tags']) && is_array($projet['tech_tags'])) {
                $html .= '                <div class="item-tags">' . "\n";
                foreach ($projet['tech_tags'] as $tag) {
                    $html .= '                    <span class="tech-tag">' . htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') . '</span>' . "\n";
                }
                $html .= '                </div>' . "\n";
            }

            if ($summary) {
                $html .= '                <p>' . $summary . '</p>' . "\n";
            }

            $html .= '                <a href="' . $url . '" class="item-link">Voir le détail <i class="fas fa-arrow-right"></i></a>' . "\n";
            $html .= '            </div>' . "\n";
            $html .= '        </div>' . "\n\n";
        }
    }

    $html .= '    </div>' . "\n";
    $html .= '</section>';

    return $html;
}