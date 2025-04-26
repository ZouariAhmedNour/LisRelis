<?php
// Définir la page actuelle
$currentPage = 'genres';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container mt-5">
    <h1>Gestion des Genres</h1>

    <!-- Afficher les messages d'erreur s'il y en a -->
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <!-- Bouton pour ajouter un genre -->
    <div class="mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGenreModal">Ajouter un Genre</button>
    </div>

    <!-- Table des genres -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($genres)): ?>
                <tr>
                    <td colspan="3" class="text-center">Aucun genre trouvé.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($genres as $genre): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($genre['nom']); ?></td>
                        <td><?php echo htmlspecialchars($genre['description']); ?></td>
                        <td>
                            <!-- Bouton Modifier -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editGenreModal<?php echo $genre['id']; ?>">Modifier</button>
                            <!-- Bouton Supprimer -->
                            <a href="<?php echo BASE_URL; ?>genres/delete/<?php echo $genre['id']; ?>" class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $genre['id']; ?>">Supprimer</a>
                        </td>
                    </tr>

                    <!-- Modale pour modifier un genre -->
                    <div class="modal fade" id="editGenreModal<?php echo $genre['id']; ?>" tabindex="-1" aria-labelledby="editGenreModalLabel<?php echo $genre['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="<?php echo BASE_URL; ?>genres/edit/<?php echo $genre['id']; ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editGenreModalLabel<?php echo $genre['id']; ?>">Modifier le Genre</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nom_<?php echo $genre['id']; ?>" class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="nom_<?php echo $genre['id']; ?>" name="nom" value="<?php echo htmlspecialchars($genre['nom']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description_<?php echo $genre['id']; ?>" class="form-label">Description</label>
                                            <textarea class="form-control" id="description_<?php echo $genre['id']; ?>" name="description" rows="3" required><?php echo htmlspecialchars($genre['description']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modale pour ajouter un genre -->
<div class="modal fade" id="addGenreModal" tabindex="-1" aria-labelledby="addGenreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo BASE_URL; ?>genres/add">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGenreModalLabel">Ajouter un Genre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>