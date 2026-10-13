/* ==========================================================================
   MAIN.JS — Global behaviors present on all pages
   Dynamic year, navbar scroll effect, mobile hamburger menu.
   ========================================================================== */

// Year in the footer
const currentYearEl = document.getElementById('current-year');
if (currentYearEl) {
    currentYearEl.textContent = new Date().getFullYear().toString();
}

// Scroll effect on the navbar (more opaque background + shadow)
const nav = document.querySelector('.navbar');
if (nav) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            nav.style.background = '#000000';
            nav.style.boxShadow = '0 5px 20px rgba(255, 49, 49, 0.1)';
        } else {
            nav.style.background = 'rgba(10, 10, 10, 0.95)';
            nav.style.boxShadow = 'none';
        }
    });
}

// Mobile hamburger menu toggle
const burger = document.querySelector('.burger');
const navLinks = document.querySelector('.nav-links');

if (burger && navLinks) {
    burger.addEventListener('click', () => {
        navLinks.classList.toggle('nav-active');
    });

    navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('nav-active');
        });
    });
}

// Track CV download action
function trackAction(actionType, targetDetail) {
    const payload = {
        event_type: actionType,
        target_label: targetDetail,
        page_url: window.location.href,
        page_title: document.title,
        screen_width: window.screen.width,
        screen_height: window.screen.height
    };
    if (navigator.sendBeacon) {
        navigator.sendBeacon('/api/track.php', new Blob([JSON.stringify(payload)], {type: 'application/json'}));
        return;
    }
    fetch('/api/track.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(payload),
        keepalive: true
    }).catch(() => {
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const startedAt = performance.now();
    const send = (payload) => {
        const body = JSON.stringify(payload);
        if (navigator.sendBeacon) {
            navigator.sendBeacon('/api/track.php', new Blob([body], {type: 'application/json'}));
        } else {
            fetch('/api/track.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body,
                keepalive: true
            }).catch(() => {});
        }
    };

    const cvLinks = document.querySelectorAll('a[href*="cv.pdf"]');

    cvLinks.forEach(link => {
        link.addEventListener('click', () => {
            trackAction('cv_download', link.getAttribute('download') ? 'cv.pdf (download)' : 'cv.pdf (view)');
        });
    });

    let maxScroll = 0;
    window.addEventListener('scroll', () => {
        const pageHeight = document.documentElement.scrollHeight - window.innerHeight;
        if (pageHeight <= 0) return;
        const depth = Math.min(100, Math.round((window.scrollY / pageHeight) * 100));
        if (depth >= maxScroll + 25) {
            maxScroll = depth;
            trackAction('scroll_depth', String(depth));
        }
    }, {passive: true});

    window.addEventListener('load', () => {
        const navigation = performance.getEntriesByType('navigation')[0];
        if (!navigation) return;
        send({
            event_type: 'performance_measure',
            page_url: window.location.href,
            ttfb_ms: Math.round(navigation.responseStart),
            dom_ready_ms: Math.round(navigation.domContentLoadedEventEnd),
            load_complete_ms: Math.round(navigation.loadEventEnd),
            navigation_type: navigation.type,
            connection_type: navigator.connection ? navigator.connection.effectiveType : null
        });
    }, {once: true});

    window.addEventListener('pagehide', () => {
        send({
            event_type: 'session_end',
            page_url: window.location.href,
            duration_seconds: Math.round((performance.now() - startedAt) / 1000)
        });
    }, {once: true});
});