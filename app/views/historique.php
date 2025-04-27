<?php
// Définir la page actuelle
$currentPage = 'historique';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container-fluid">
    <h1 class="text-center mb-4">Mon Historique d'Emprunts</h1>

    <section>
        <?php if (empty($borrowHistory)): ?>
            <p>Aucun emprunt trouvé.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>État</th>
                        <th>Titre du livre</th>
                        <th>Date d'emprunt</th>
                        <th>Date de retour</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrowHistory as $emprunt): ?>
                        <?php
                        $today = new DateTime();
                        $dateRetour = !empty($emprunt['date_retour']) ? new DateTime($emprunt['date_retour']) : null;
                        $isLate = $dateRetour && $today > $dateRetour;
                        $isReturned = isset($emprunt['disponible']) && $emprunt['disponible'] == 1;
                        $isOngoing = !$isReturned && !$isLate;
                        ?>
                        <tr>
                            <td>
                                <?php if ($isReturned): ?>
                                    <span class="text-success">✓</span> <!-- Icône de validation verte -->
                                <?php elseif ($isLate): ?>
                                    <span class="text-danger">⚠</span> <!-- Icône d'alerte rouge -->
                                    <small class="text-danger">S'il vous plaît, retournez le livre le plus tôt possible.</small>
                                <?php else: ?>
                                    <span class="text-warning">⚠</span> <!-- Icône d'exclamation orange -->
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($emprunt['titre'] ?? 'Titre inconnu', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($emprunt['date_emprunt'] ?? 'Non défini', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($emprunt['date_retour'] ?? 'Non défini', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php if ($isOngoing && isset($emprunt['livre_id']) && isset($emprunt['emprunt_id'])): ?>
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="livre_id" value="<?php echo htmlspecialchars($emprunt['livre_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="emprunt_id" value="<?php echo htmlspecialchars($emprunt['emprunt_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <button type="submit" name="return_book" class="btn btn-success">Retourner</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <a href="<?php echo BASE_URL; ?>profil" class="btn btn-secondary">Retour</a>
    </section>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>