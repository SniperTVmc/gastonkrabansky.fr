/* ==========================================================================
   MAIN.JS — Comportements globaux présents sur toutes les pages
   Année dynamique, effet de la navbar au scroll, menu burger mobile.
   ========================================================================== */

// Année dynamique dans le pied de page
const currentYearEl = document.getElementById('current-year');
if (currentYearEl) {
    currentYearEl.textContent = new Date().getFullYear();
}

// Effet de la navbar au scroll (fond plus opaque + ombre)
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

// Menu burger (navigation mobile)
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
