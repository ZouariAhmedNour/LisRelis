<?php
// Définir la page actuelle
$currentPage = 'profilAdmin';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container-fluid">
    <h1 class="text-center mb-4">Profil Admin</h1>

    <!-- Section 1 : Tableau des emprunts proches -->
    <section class="mb-5">
        <h2>Emprunts avec date de retour proche</h2>
        <?php if (empty($upcomingReturns)): ?>
            <p>Aucun emprunt avec une date de retour proche.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom de l'utilisateur</th>
                        <th>Titre du livre</th>
                        <th>Date d'emprunt</th>
                        <th>Date de retour</th>
                        <th>Jours restants</th>
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
                                <button class="btn btn-warning send-alert" data-user-id="<?php echo htmlspecialchars($row['utilisateur_id']); ?>">Envoyer une alerte</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <!-- Section 2 : Recherche d'utilisateurs -->
    <section>
        <h2>Rechercher un utilisateur</h2>
        <form method="POST" action="" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Nom, email ou téléphone" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>

        <?php if (!empty($searchResults)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($searchResults as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['nom']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['telephone']); ?></td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>userDetails/<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-info">Voir détails</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($_POST['search'])): ?>
            <p>Aucun utilisateur trouvé.</p>
        <?php endif; ?>
    </section>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>