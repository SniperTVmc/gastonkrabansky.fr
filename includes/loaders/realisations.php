<?php

function getRealisationDirectory(): string
{
    return __DIR__ . '/../../content/bts-sio/realisations/';
}

function getAllRealisationsData(): array
{
    $dir = getRealisationDirectory();
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

function getRealisationItemById($id)
{
    $dir = getRealisationDirectory();
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

function getReferentielOfficiel(): array
{
    $filePath = __DIR__ . '/../../content/bts-sio/referentiel-sio.json';
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        return json_decode($content, true) ?? [];
    }
    return [];
}

function renderRealisationsPageHtml(string $detailLinkBase = '/bts-sio/realisations/'): string
{
    $realisations = getAllRealisationsData();

    $html = '<section class="container">' . "\n";
    $html .= '    <div style="display: flex; flex-direction: column; gap: 30px;">' . "\n";

    if (empty($realisations)) {
        $html .= '        <p style="text-align:center;">Aucune réalisation enregistrée.</p>' . "\n";
    } else {
        foreach ($realisations as $item) {
            $id = $item['id'] ?? '';
            $title = htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8');
            $period = htmlspecialchars($item['period'] ?? '', ENT_QUOTES, 'UTF-8');
            $icon = htmlspecialchars($item['icon'] ?? 'fas fa-laptop-code', ENT_QUOTES, 'UTF-8');
            $detailUrl = $detailLinkBase . urlencode($id);
            $blocsMobilises = $item['blocs_mobilises'] ?? [];

            $html .= '        <div class="info-block" style="display: flex; flex-direction: column; gap: 15px;">' . "\n";
            $html .= '            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px;">' . "\n";
            $html .= '                <div>' . "\n";
            $html .= '                    <h3 style="margin-bottom: 5px;"><i class="' . $icon . '"></i> <a href="' . $detailUrl . '" style="color: inherit; text-decoration: none;">' . $title . '</a></h3>' . "\n";
            $html .= '                    <span class="date" style="color: var(--main-color); font-size: 0.85rem; font-weight: bold;"><i class="far fa-calendar-alt"></i> ' . $period . '</span>' . "\n";
            $html .= '                </div>' . "\n";
            $html .= '                <div>' . "\n";
            $html .= '                    <a href="' . $detailUrl . '" class="btn btn-outline sm">Analyse par blocs <i class="fas fa-arrow-right"></i></a>' . "\n";
            $html .= '                </div>' . "\n";
            $html .= '            </div>' . "\n";

            $html .= '            <div style="border-top: 1px solid var(--border-color); padding-top: 15px; margin-top: 5px;">' . "\n";
            $html .= '                <p style="font-size: 0.85rem; font-weight: bold; margin-bottom: 10px; color: var(--text-color);">Blocs de compétences du référentiel mobilisés :</p>' . "\n";
            $html .= '                <div style="display: flex; flex-wrap: wrap; gap: 8px;">' . "\n";
            foreach ($blocsMobilises as $bMobilise) {
                $html .= '                    <span class="tech-tag" style="background: rgba(255, 49, 49, 0.08); border: 1px solid var(--main-color); color: var(--text-color);"><i class="fas fa-layer-group" style="color: var(--main-color); margin-right: 5px;"></i> ' . htmlspecialchars($bMobilise, ENT_QUOTES, 'UTF-8') . '</span>' . "\n";
            }
            $html .= '                </div>' . "\n";
            $html .= '            </div>' . "\n";
            $html .= '        </div>' . "\n";
        }
    }

    $html .= '    </div>' . "\n";
    $html .= '</section>';

    return $html;
}

function renderRealisationsDetailHtml($item): string
{
    if (!$item) {
        $html = '<section class="container">' . "\n";
        $html .= '    <a href="/bts-sio/realisations" class="back-link"><i class="fas fa-arrow-left"></i> Retour aux réalisations</a>' . "\n\n";
        $html .= '    <div class="detail-content" style="text-align: center; padding: 40px 0;">' . "\n";
        $html .= '        <h1>Réalisation introuvable</h1>' . "\n";
        $html .= '        <p style="margin: 20px 0; color: var(--text-secondary);">La réalisation que vous recherchez n\'existe pas ou a été déplacée.</p>' . "\n";
        $html .= '    </div>' . "\n";
        $html .= '</section>';
        return $html;
    }

    $title = htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8');
    $period = htmlspecialchars($item['period'] ?? '', ENT_QUOTES, 'UTF-8');
    $link = $item['link'] ?? null;
    $projetDetails = $item['realisation_details'] ?? [];
    $referentielOfficiel = getReferentielOfficiel();

    $domainesReferentiel = [
        'bloc1' => [
            'title' => 'Bloc 1 : Support & Services',
            'subtitle' => 'Référentiel officiel : Support et mise à disposition de services informatiques',
            'desc' => 'Gestion du patrimoine informatique, réponse aux incidents, présence en ligne, mode projet et déploiement.'
        ],
        'bloc2' => [
            'title' => 'Bloc 2 : Conception & Dev (SLAM)',
            'subtitle' => 'Référentiel officiel : Conception et développement d’applications',
            'desc' => 'Conception, développement de solutions applicatives, maintenance et gestion/exploitation des données.'
        ],
        'bloc3' => [
            'title' => 'Bloc 3 : Cybersécurité',
            'subtitle' => 'Référentiel officiel : Cybersécurité des services informatiques',
            'desc' => 'Protection des données, sécurisation des équipements, des applications et des usages utilisateurs.'
        ]
    ];

    $html = '<section class="container">' . "\n";
    $html .= '    <a href="/bts-sio/realisations" class="back-link"><i class="fas fa-arrow-left"></i> Retour aux réalisations</a>' . "\n\n";

    $html .= '    <div class="detail-content" style="margin-bottom: 30px;">' . "\n";
    $html .= '        <h1>' . $title . '</h1>' . "\n";
    $html .= '        <div class="detail-meta">' . "\n";
    if ($period) {
        $html .= '            <span class="stat-tag"><i class="far fa-calendar-alt"></i> ' . $period . '</span>' . "\n";
    }
    $html .= '        </div>' . "\n";
    if ($link) {
        $html .= '        <div class="detail-links" style="margin-top: 20px;">' . "\n";
        $html .= '            <a href="' . htmlspecialchars($link['url'], ENT_QUOTES, 'UTF-8') . '" class="btn btn-fill" target="_blank"><i class="fas fa-external-link-alt"></i> ' . htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8') . '</a>' . "\n";
        $html .= '        </div>' . "\n";
    }
    $html .= '    </div>' . "\n\n";

    $html .= '    <div class="tab-buttons">' . "\n";
    $isActiveTab = true;
    foreach ($domainesReferentiel as $key => $domaine) {
        $activeClass = $isActiveTab ? ' active' : '';
        $html .= '        <button class="tab-btn' . $activeClass . '" data-target="#' . $key . '">' . $domaine['title'] . '</button>' . "\n";
        $isActiveTab = false;
    }
    $html .= '    </div>' . "\n\n";

    $isActiveContent = true;
    foreach ($domainesReferentiel as $key => $domaine) {
        $activeContentClass = $isActiveContent ? ' active-content' : '';
        $html .= '    <div class="tab-content' . $activeContentClass . '" id="' . $key . '">' . "\n";

        $html .= '        <div class="info-block" style="margin-bottom: 30px; border-left: 4px solid var(--main-color);">' . "\n";
        $html .= '            <span style="font-size: 0.8rem; font-weight: bold; color: var(--main-color); text-transform: uppercase; letter-spacing: 0.5px;">' . $domaine['subtitle'] . '</span>' . "\n";
        $html .= '            <h3 style="color: var(--text-color); margin: 6px 0 8px 0; font-size: 1.3rem;">' . $domaine['title'] . '</h3>' . "\n";
        $html .= '            <p style="margin: 0; color: var(--text-secondary); font-size: 0.95rem;">' . $domaine['desc'] . '</p>' . "\n";
        $html .= '        </div>' . "\n";

        $blocRef = $referentielOfficiel[$key] ?? [];
        $competencesRef = $blocRef['competences'] ?? [];
        $blocProjet = $projetDetails[$key] ?? [];

        if (empty($competencesRef)) {
            $html .= '        <p style="color: var(--text-secondary); font-style: italic;">Aucune compétence répertoriée pour ce bloc.</p>' . "\n";
        } else {
            $html .= '        <div style="display: flex; flex-direction: column; gap: 20px;">' . "\n";

            foreach ($competencesRef as $compNom => $sousCompList) {
                $html .= '            <div class="info-block" style="margin-bottom: 0;">' . "\n";
                $html .= '                <h4 style="font-size: 1.2rem; color: var(--text-color); margin-bottom: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">' . htmlspecialchars($compNom, ENT_QUOTES, 'UTF-8') . '</h4>' . "\n";

                if (!empty($sousCompList)) {
                    $html .= '                <div style="display: flex; flex-direction: column; gap: 12px;">' . "\n";
                    foreach ($sousCompList as $libelleSub) {
                        $subData = $blocProjet[$compNom][$libelleSub] ?? null;

                        $isValide = ($subData && ($subData['status'] ?? '') === 'valide');
                        $statusIcon = $isValide ? '<i class="fas fa-check-circle" style="color: var(--success-color);"></i> Validée' : '<i class="fas fa-times-circle" style="color: var(--text-secondary);"></i> Non validée / Non concernée';
                        $subOpacity = $isValide ? '1' : '0.65';
                        $tagBg = $isValide ? 'rgba(46, 204, 113, 0.1)' : 'rgba(120, 120, 120, 0.1)';
                        $tagBorder = $isValide ? 'var(--success-color)' : 'var(--border-color)';
                        $tagColor = $isValide ? 'var(--success-color)' : 'var(--text-secondary)';
                        $description = $subData['description'] ?? 'Non abordé / non concerné par ce projet.';

                        $html .= '                    <div style="background: var(--bg-color); padding: 12px; border-radius: 8px; border: 1px solid var(--border-color); opacity: ' . $subOpacity . ';">' . "\n";
                        $html .= '                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; flex-wrap: wrap; margin-bottom: 6px;">' . "\n";
                        $html .= '                            <span style="font-size: 0.9rem; font-weight: bold; color: var(--text-color);">• ' . htmlspecialchars($libelleSub, ENT_QUOTES, 'UTF-8') . '</span>' . "\n";
                        $html .= '                            <span class="tech-tag" style="background: ' . $tagBg . '; border: 1px solid ' . $tagBorder . '; color: ' . $tagColor . '; font-size: 0.75rem; padding: 2px 8px;">' . $statusIcon . '</span>' . "\n";
                        $html .= '                        </div>' . "\n";
                        $html .= '                        <p style="margin: 0; color: var(--text-secondary); font-size: 0.9rem; text-align: left;">' . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . '</p>' . "\n";
                        $html .= '                    </div>' . "\n";
                    }
                    $html .= '                </div>' . "\n";
                }

                $html .= '            </div>' . "\n";
            }

            $html .= '        </div>' . "\n";
        }

        $html .= '    </div>' . "\n\n";
        $isActiveContent = false;
    }

    $html .= '</section>';

    return $html;
}