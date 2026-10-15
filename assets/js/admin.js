/* ==========================================================================
   ADMIN.JS — Logic of the Charts and Interactions in the Admin Panel
   ========================================================================== */

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.stats-period-select').forEach(select => {
        select.addEventListener('change', () => {
            const form = select.closest('form');
            if (form) {
                form.submit();
            }
        });
    });

    document.querySelectorAll('.admin-nav-toggle').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const group = toggle.closest('.admin-nav-group');
            const open = group.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    });
    document.querySelectorAll('.admin-skill-item input[type="checkbox"]').forEach(checkbox => {
        const description = checkbox.closest('.admin-skill-item')?.querySelector('textarea');
        if (!description) return;
        const updateVisibility = () => {
            description.hidden = !checkbox.checked;
            description.required = checkbox.checked;
        };
        checkbox.addEventListener('change', updateVisibility);
        updateVisibility();
    });

    document.querySelectorAll('.admin-delete-form').forEach(form => {
        form.addEventListener('submit', event => {
            if (!window.confirm(form.dataset.confirm || 'Confirmer la suppression ?')) event.preventDefault();
        });
    });

    const editorForm = document.querySelector('.admin-realisation-form');
    if (editorForm) {
        let initialState = new FormData(editorForm);
        const hasChanges = () => {
            const current = new FormData(editorForm);
            const initialEntries = Array.from(initialState.entries());
            const currentEntries = Array.from(current.entries());
            return JSON.stringify(initialEntries) !== JSON.stringify(currentEntries);
        };
        editorForm.addEventListener('submit', () => { initialState = new FormData(editorForm); });
        window.addEventListener('beforeunload', event => {
            if (hasChanges()) {
                event.preventDefault();
                event.returnValue = '';
            }
        });
    }

    const iconInput = document.getElementById('realisation-icon');
    const iconPreview = document.getElementById('realisation-icon-preview');
    const iconStatus = document.getElementById('realisation-icon-status');
    if (iconInput && iconPreview && iconStatus) {
        const updateIconPreview = () => {
            const value = iconInput.value.trim();
            iconPreview.className = value;
            if (!value || !/^fa[srbkltd]?\s+fa-[a-z0-9-]+$/i.test(value)) {
                iconStatus.textContent = 'Format attendu : fas fa-nom-de-licone';
                iconStatus.className = 'admin-field-help is-invalid';
                return;
            }
            const content = window.getComputedStyle(iconPreview, '::before').content;
            const exists = content && content !== 'none' && content !== 'normal';
            iconStatus.textContent = exists ? 'Icône détectée' : 'Icône introuvable dans Font Awesome';
            iconStatus.className = `admin-field-help ${exists ? 'is-valid' : 'is-invalid'}`;
        };
        iconInput.addEventListener('input', updateIconPreview);
        updateIconPreview();
    }
    document.querySelectorAll('.stats-chart').forEach(canvas => {
        if (typeof Chart === 'undefined') return;
        try {
            const config = JSON.parse(canvas.dataset.config || '{}');
            const colors = ['#df9b67', '#5b9f72', '#e5a954', '#8c5837', '#4f46e5', '#a855f7'];
            (config.datasets || []).forEach((dataset, index) => {
                dataset.backgroundColor = dataset.backgroundColor || (config.type === 'line' ? 'rgba(223,155,103,.15)' : colors[index % colors.length]);
                dataset.borderColor = dataset.borderColor || colors[index % colors.length];
                if (config.type === 'line') { dataset.fill = dataset.fill !== false; dataset.tension = .3; }
            });
            new Chart(canvas.getContext('2d'), { type: config.type || 'bar', data: { labels: config.labels || [], datasets: config.datasets || [] },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: (config.datasets || []).length > 1, position: 'bottom' } },
                    scales: config.type === 'doughnut' ? {} : { y: { beginAtZero: true, ticks: { precision: 0 } } } } });
        } catch (error) { console.error('Erreur graphique statistiques:', error); }
    });
    const statsCanvas = document.getElementById('stats-chart');
    if (statsCanvas && typeof Chart !== 'undefined') {
        try {
            new Chart(statsCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: JSON.parse(statsCanvas.dataset.labels || '[]'),
                    datasets: [{
                        label: 'Occurrences',
                        data: JSON.parse(statsCanvas.dataset.values || '[]'),
                        backgroundColor: '#df9b67',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        } catch (error) {
            console.error('Erreur stats-chart:', error);
        }
    }

    const lineChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0, color: '#aba19a' },
                grid: { color: 'rgba(255, 255, 255, 0.05)' }
            },
            x: {
                ticks: { color: '#aba19a' },
                grid: { display: false }
            }
        }
    };

    const doughnutChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#f7f4f0',
                    font: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
                    padding: 20
                }
            }
        },
        cutout: '70%'
    };

    // 1. Visits Chart (Line Chart - Last 14 Days)
    const visitsCanvas = document.getElementById('visitsChart');
    if (visitsCanvas) {
        try {
            const labelsDays = JSON.parse(visitsCanvas.dataset.labels || '[]');
            const countsDays = JSON.parse(visitsCanvas.dataset.counts || '[]');

            new Chart(visitsCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: labelsDays,
                    datasets: [{
                        label: 'Visites',
                        data: countsDays,
                        backgroundColor: 'rgba(223, 155, 103, 0.1)',
                        borderColor: '#df9b67',
                        borderWidth: 3,
                        tension: 0.35,
                        fill: true,
                        pointBackgroundColor: '#df9b67',
                        pointBorderColor: '#0b0908',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: lineChartOptions
            });
        } catch (e) {
            console.error("Erreur visitsChart:", e);
        }
    }

    // 2. Peak Hours Chart (Bars or Lines - 12:00 a.m. to 11:00 p.m.)
    const hoursCanvas = document.getElementById('hoursChart');
    if (hoursCanvas) {
        try {
            const countsHours = JSON.parse(hoursCanvas.dataset.counts || '[]');
            const hoursLabels = Array.from({length: 24}, (_, i) => `${i}h`);

            new Chart(hoursCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: hoursLabels,
                    datasets: [{
                        label: 'Visites par heure',
                        data: countsHours,
                        backgroundColor: 'rgba(91, 159, 114, 0.6)',
                        borderColor: '#5b9f72',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: lineChartOptions
            });
        } catch (e) {
            console.error("Erreur hoursChart:", e);
        }
    }

    // Generic Function for Doughnuts (Devices, Languages, Regions)
    function initDoughnutChart(canvasId, defaultLabel) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;

        try {
            const labels = JSON.parse(canvas.dataset.labels || '[]');
            const counts = JSON.parse(canvas.dataset.counts || '[]');

            const finalLabels = labels.length > 0 ? labels : [defaultLabel];
            const finalCounts = counts.length > 0 ? counts : [1];

            new Chart(canvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: finalLabels,
                    datasets: [{
                        data: finalCounts,
                        backgroundColor: ['#df9b67', '#5b9f72', '#e5a954', '#8c5837', '#4f46e5', '#a855f7'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: doughnutChartOptions
            });
        } catch (e) {
            console.error(`Erreur ${canvasId}:`, e);
        }
    }

    // Initializing the 3 pie charts
    initDoughnutChart('deviceChart', 'Desktop');
    initDoughnutChart('langChart', 'FR');
    initDoughnutChart('regionChart', 'Inconnue');
});