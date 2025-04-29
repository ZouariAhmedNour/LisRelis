<?php
// Définir la page actuelle
$currentPage = 'profilAdmin';

// Vérifier si l'utilisateur est un admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 0) {
    header('Location: ' . BASE_URL . 'login');
    exit;
}

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container mt-5">
    <h1>Gestion des Utilisateurs</h1>

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
        <div class="alert alert-success">
            <p><?php echo htmlspecialchars($_SESSION['success']); ?></p>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Section 1 : Tableau des emprunts proches -->
    <section class="mb-5">
        <h2>Emprunts avec Date de Retour Proche</h2>
        <?php if (empty($upcomingReturns)): ?>
            <p class="text-center">Aucun emprunt avec une date de retour proche.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom de l'Utilisateur</th>
                        <th>Titre du Livre</th>
                        <th>Date d'Emprunt</th>
                        <th>Date de Retour</th>
                        <th>Jours Restants</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($upcomingReturns as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nom']); ?></td>
                            <td><?php echo htmlspecialchars($row['titre']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_emprunt']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_retour']); ?></td>
                            <td><?php echo htmlspecialchars($row['jours_restants']); ?> jour(s)</td>
                            <td>
                                <button class="btn btn-sm btn-warning send-alert" 
                                        data-user-id="<?php echo htmlspecialchars($row['utilisateur_id']); ?>" 
                                        data-book-title="<?php echo htmlspecialchars($row['titre']); ?>" 
                                        data-return-date="<?php echo htmlspecialchars($row['date_retour']); ?>">
                                    Envoyer une Alerte
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <!-- Section 2 : Recherche d'utilisateurs -->
    <section>
        <h2>Rechercher un Utilisateur</h2>
        <form method="POST" action="" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Nom ou email" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>

        <?php if (!empty($searchResults)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($searchResults as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['nom']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo $user['role'] == 0 ? 'Admin' : 'Utilisateur'; ?></td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>profilAdmin/userDetails/<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-sm btn-info">Voir Détails</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($_POST['search'])): ?>
            <p class="text-center">Aucun utilisateur trouvé.</p>
        <?php endif; ?>
    </section>
</div>

<!-- Inclure SweetAlert2 pour les notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.send-alert').forEach(button => {
    button.addEventListener('click', function() {
        const userId = this.getAttribute('data-user-id');
        const bookTitle = this.getAttribute('data-book-title');
        const returnDate = this.getAttribute('data-return-date');

        // Envoyer une requête AJAX pour envoyer l'alerte
        fetch('<?php echo BASE_URL; ?>profilAdmin/sendAlert', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `send_alert=true&user_id=${userId}&book_title=${bookTitle}&return_date=${returnDate}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Une erreur est survenue lors de l\'envoi de l\'alerte.',
                confirmButtonText: 'OK'
            });
        });
    });
});
</script>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>