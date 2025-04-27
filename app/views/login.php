<?php
// Définir la page actuelle
$currentPage = 'login';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    <!-- Logo centré en haut -->
    <div class="mb-4">
        <img src="<?php echo BASE_URL; ?>assets/images/Logo.png" alt="Lis & Relis Logo" style="height: 80px;">
    </div>

    <!-- Formulaire de connexion -->
    <div class="p-4 rounded" style="width: 100%; max-width: 400px; background-color: #ffffff;">
        <h1 class="text-center mb-4" style="font-weight: bold; color: #2C1B2E;">Connexion</h1>
        <form method="POST" action="<?php echo BASE_URL; ?>login" id="loginForm">
            <?php if (!empty($message)): ?>
                <div id="login-error" class="alert alert-danger">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn w-100" style="background-color: #A65482; color: white;">Se connecter</button>

            <div class="text-center mt-3">
                <a href="/forgot-password" class="text-decoration-none" style="color: #2C1B2E;">Mot de passe oublié ?</a>
            </div>
            <div class="text-center mt-2">
                <span>Pas encore de compte ?</span>
                <a href="<?php echo BASE_URL; ?>" class="text-decoration-underline" style="color: #2C1B2E;">S'inscrire</a>
            </div>
        </form>
    </div>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>
