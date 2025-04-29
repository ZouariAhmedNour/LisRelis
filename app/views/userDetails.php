<?php
// Définir la page actuelle
$currentPage = 'userDetails';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container mt-5">
    <h1>Détails de l'Utilisateur</h1>

    <!-- Afficher les messages d'erreur s'il y en a -->
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <!-- Afficher les messages de succès s'il y en a -->
    <?php if (isset($_SESSION['success'])): ?>
        <div id="success-message" data-success-message="<?php echo htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8'); ?>" style="display: none;"></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Bouton pour modifier l'utilisateur -->
    <div class="mb-4">
        <a href="<?php echo BASE_URL; ?>editUser/<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-primary">Modifier Utilisateur</a>
        <a href="<?php echo BASE_URL; ?>profilAdmin" class="btn btn-secondary">Retour</a>
    </div>

    <!-- Section 1 : Informations de l'utilisateur -->
    <section class="mb-5">
        <h2>Informations</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Champ</th>
                    <th>Valeur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nom</td>
                    <td><?php echo htmlspecialchars($user['nom']); ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <td>Téléphone</td>
                    <td><?php echo htmlspecialchars($user['telephone']); ?></td>
                </tr>
                <tr>
                    <td>Rôle</td>
                    <td><?php echo $user['role'] == 0 ? 'Admin' : 'Utilisateur'; ?></td>
                </tr>
            </tbody>
        </table>
    </section>

    <!-- Section 2 : Historique des emprunts -->
    <section>
        <h2>Historique des Emprunts</h2>
        <?php if (empty($borrowHistory)): ?>
            <p class="text-center">Aucun emprunt trouvé pour cet utilisateur.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre du Livre</th>
                        <th>Date d'Emprunt</th>
                        <th>Date de Retour</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrowHistory as $emprunt): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($emprunt['titre']); ?></td>
                            <td><?php echo htmlspecialchars($emprunt['date_emprunt']); ?></td>
                            <td><?php echo htmlspecialchars($emprunt['date_retour']); ?></td>
                            <td>
                                <span class="badge <?php echo $emprunt['disponible'] == 1 ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo $emprunt['disponible'] == 1 ? 'Disponible' : 'Emprunté'; ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($emprunt['disponible'] == 0): ?>
                                    <a href="<?php echo BASE_URL; ?>profilAdmin/returnBook/<?php echo $emprunt['livre_id']; ?>/<?php echo $emprunt['emprunt_id']; ?>" class="btn btn-sm btn-success">Marquer comme rendu</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>

<!-- Ajouter SweetAlert2 pour les messages de succès -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessageElement = document.querySelector('#success-message');
        if (successMessageElement) {
            const message = successMessageElement.getAttribute('data-success-message');
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: message,
                confirmButtonText: 'OK'
            });
        }
    });
</script>
?>