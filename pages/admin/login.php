<?php
session_start();
if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {
    header('Location: /admin/dashboard');
    exit;
}
require_once __DIR__ . '/../../includes/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            if (password_needs_rehash($user['password'], PASSWORD_ARGON2ID)) {
                $newHash = password_hash($password, PASSWORD_ARGON2ID);
                $updateStmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                $updateStmt->execute([$newHash, $user['id']]);
            }
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_user'] = $user['username'];
            header('Location: /admin/dashboard');
            exit;
        } else {
            $error = 'Identifiant ou mot de passe incorrect.';
        }
    } else {
        $error = 'Veuillez remplir tous les champs.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

    <?php include __DIR__ . "/../../includes/admin/header.php"; ?>

    <body data-page="admin-login">

    <div class="container admin-login-wrapper">
        <div class="contact-form admin-login-box">
            <div class="admin-login-header">
                <i class="fa-solid fa-lock"></i>
                <h1>Espace Admin</h1>
                <p>Connexion sécurisée requise</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="form-message error admin-error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="/admin" method="POST">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur <span class="required">*</span></label>
                    <input type="text" id="username" name="username" required placeholder="admin">
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-fill submit-btn">
                    <i class="fa-solid fa-right-to-bracket"></i> Se connecter
                </button>
            </form>

            <div class="admin-back-container">
                <a href="/" class="back-link"><i class="fa-solid fa-arrow-left"></i> Retour au site</a>
            </div>
        </div>
    </div>

    </body>
</html>