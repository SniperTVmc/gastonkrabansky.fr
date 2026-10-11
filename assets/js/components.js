/* ==========================================================================
   COMPONENTS.JS — Comportements des composants interactifs
   Système d'onglets (page parcours) + envoi du formulaire de contact.
   ========================================================================== */

// --- Système d'onglets ---
const tabBtns = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

if (tabBtns.length && tabContents.length) {
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active-content'));

            btn.classList.add('active');

            const targetId = btn.getAttribute('data-target');
            document.querySelector(targetId).classList.add('active-content');
        });
    });
}

// --- Formulaire de contact (Web3Forms) ---
const contactForm = document.getElementById('contact-form');
const formMessage = document.getElementById('form-message');

if (contactForm && formMessage) {
    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const object = Object.fromEntries(formData);
        const json = JSON.stringify(object);

        formMessage.className = 'form-message';
        formMessage.textContent = 'Envoi en cours...';
        formMessage.style.display = 'block';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: json
            });

            const result = await response.json();

            if (response.ok && result.success) {
                formMessage.textContent = "✅ Message envoyé avec succès ! Merci de m'avoir contacté.";
                formMessage.classList.add('success');
                form.reset();
            } else {
                formMessage.textContent = "❌ Erreur lors de l'envoi. Veuillez réessayer ou m'envoyer un mail directement.";
                formMessage.classList.add('error');
            }
        } catch (error) {
            formMessage.textContent = "❌ Erreur lors de l'envoi. Veuillez réessayer ou m'envoyer un mail directement.";
            formMessage.classList.add('error');
            console.error('Erreur du formulaire :', error);
        }
    });
}
