/* ==========================================================================
   NAVIGATION.JS — Mise en surbrillance du lien de navigation actif
   Chaque page définit un attribut data-page sur <body> (ex : data-page="projets").
   Chaque lien de la navbar porte le même attribut sur data-nav.
   On compare simplement les deux pour ajouter la classe "active".
   ========================================================================== */

const currentPage = document.body.dataset.page;

if (currentPage) {
    document.querySelectorAll('.nav-links a[data-nav]').forEach(link => {
        if (link.dataset.nav === currentPage) {
            link.classList.add('active');
        }
    });
}
