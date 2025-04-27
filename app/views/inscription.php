<?php
// Définir la page actuelle
$currentPage = 'inscription';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container-fluid position-relative">
    <!-- Logo dans le coin supérieur gauche -->
    <div class="logo position-absolute top-0 start-0">
        <img src="<?php echo BASE_URL; ?>assets/images/Logo.png" alt="Lis & Relis Logo" style="height: 100px;">
    </div>

    <!-- Contenu prenant toute la largeur -->
    <div class="login-content">
        <h1 class="text-center mb-4">Inscription</h1>
        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form method="POST" action="" id="inscriptionForm">
            <div class="d-flex align-items-center mb-3 form-group">
                <label for="nom" class="form-label login-label me-3">Nom</label>
                <input type="text" class="form-control login-input" id="nom" name="nom" value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required>
            </div>
            <div class="d-flex align-items-center mb-3 form-group">
                <label for="email" class="form-label login-label me-3">Email</label>
                <input type="email" class="form-control login-input" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="d-flex align-items-center mb-3 form-group">
                <label for="telephone" class="form-label login-label me-3">Téléphone</label>
                <input type="tel" class="form-control login-input" id="telephone" name="telephone" value="<?php echo isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : ''; ?>">
            </div>
            <div class="d-flex align-items-center mb-3 form-group">
                <label for="password" class="form-label login-label me-3">Mot de passe</label>
                <input type="password" class="form-control login-input" id="password" name="password" required>
            </div>
            <div class="d-flex align-items-center mb-3 form-group">
                <label for="mot_de_passe_confirm" class="form-label login-label me-3">Confirmer le mot de passe</label>
                <input type="password" class="form-control login-input" id="mot_de_passe_confirm" name="mot_de_passe_confirm" required>
            </div>
            <button type="submit" class="btn btn-primary login-btn w-100 mb-3" id="inscrireBtn">S'inscrire</button>
            <a href="<?php echo BASE_URL; ?>login" class="btn btn-secondary login-btn w-100" id="connecterBtn">Se connecter</a>
        </form>
    </div>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>