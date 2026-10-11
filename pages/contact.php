<?php
    $page_seo_key = 'contact';
?>
<!DOCTYPE html>
<html lang="fr">


    <!-- Header -->
    <?php include __DIR__ . "/../includes/header.php"; ?>

    <body data-page="contact">


        <!-- Navbar -->
        <?php include __DIR__ . "/../includes/navbar.php"; ?>


        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="/">Accueil</a> / <span class="current">Contact</span>
        </div>


        <!-- Page Header -->
        <div class="page-header">
            <h1>Me <span>Contacter</span></h1>
            <p>
                Vous avez un projet, une question ou une suggestion ?
                N’hésitez pas à me contacter via le formulaire ci-dessous ou via un des liens de contact alternatifs.
            </p>
        </div>


        <!-- Page Content -->
        <section class="container">
            <form id="contact-form" class="contact-form" action="https://api.web3forms.com/submit" method="POST">
                <input type="hidden" name="access_key" value="e9e4f16b-9dd7-4356-9534-e4461f55eedc">

                <div class="form-group">
                    <label for="name">Nom / Entreprise <span class="required">*</span></label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="subject">Objet</label>
                    <input type="text" id="subject" name="subject">
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="message">Votre message <span class="required">*</span></label>
                    <textarea id="message" name="message" rows="6" required></textarea>
                </div>

                <div id="h-captcha" class="h-captcha" data-captcha="true" data-lang="fr" data-theme="dark"></div>

                <button type="submit" class="btn btn-fill submit-btn">Envoyer le message <i class="fas fa-paper-plane"></i></button>
                <p id="form-message" class="form-message"></p>
            </form>

            <div class="contact-alt">
                <p>Vous pouvez aussi me joindre directement :</p>
                <div class="social-icons" style="justify-content:center; display:flex; margin-top:15px;">
                    <a href="https://www.linkedin.com/in/gaston-krabansky/" target="_blank" aria-label="Profil LinkedIn de Gaston Krabansky"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://github.com/SniperTVmc/" target="_blank" aria-label="Profil GitHub de Gaston Krabansky"><i class="fab fa-github"></i></a>
                    <a href="mailto:gaston.krabansky@gmail.com" target="_blank" aria-label="E-Mail de Gaston Krabansky"><i class="fas fa-envelope"></i></a>
                    <a href="tel:+33648545504" target="_blank" aria-label="Téléphone de Gaston Krabansky"><i class="fas fa-phone"></i></a>
                </div>
            </div>
        </section>


        <!-- Footer -->
        <?php include __DIR__ . "/../includes/footer.php"; ?>


        <!-- Web3Forms script -->
        <script src="https://web3forms.com/client/script.js" integrity="sha384-RAEN05LS0g1hNSQ83f+OkhWoEoxdCuUHArmMFGnF9YJzre1Fgg997JEue49FL+zH" crossorigin="anonymous" async defer></script>

    </body>
</html>
