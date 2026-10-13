/* ==========================================================================
   NAVIGATION.JS — Highlighting the active navigation link
   Each page defines a `data-page` attribute on `<body>` (e.g., `data-page="projects"`).
   Each link in the navbar has the same attribute on `data-nav`.
   We simply compare the two to add the "active" class.
   ========================================================================== */

const currentPage = document.body.dataset.page;

if (currentPage) {
    document.querySelectorAll('.nav-links a[data-nav], .admin-nav-links a[data-nav]').forEach(link => {
        if (link.dataset.nav === currentPage) {
            link.classList.add('active');
        }
    });
}
