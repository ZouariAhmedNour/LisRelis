<?php
// Définir la page actuelle
$currentPage = 'editProfil';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container mt-5">
    <h1>Modifier Mon Profil</h1>

    <!-- Afficher les messages d'erreur ou de succès -->
    <?php if (!empty($message)): ?>
        <div class="alert <?php echo strpos($message, 'succès') !== false ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire de modification -->
    <form method="POST" action="<?php echo BASE_URL; ?>editProfil" id="editProfilForm">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone (optionnel)</label>
            <input type="tel" class="form-control" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user['telephone'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Nouveau mot de passe (laisser vide pour ne pas modifier)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="mot_de_passe_confirm" class="form-label">Confirmer le nouveau mot de passe</label>
            <input type="password" class="form-control" id="mot_de_passe_confirm" name="mot_de_passe_confirm">
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        <a href="<?php echo BASE_URL; ?>profil" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>