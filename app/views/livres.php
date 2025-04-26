<?php
// Définir la page actuelle
$currentPage = 'livres';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container mt-5">
    <h1>Gestion des Livres</h1>

    <!-- Formulaire de filtre -->
    <div class="mb-4">
        <form class="d-flex" method="GET" action="">
            <input class="form-control me-2" type="search" name="search" placeholder="Rechercher par titre ou auteur..." aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="btn btn-primary" type="submit">Rechercher</button>
        </form>
    </div>

    <!-- Afficher les messages d'erreur s'il y en a -->
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <!-- Bouton pour ajouter un livre -->
    <div class="mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">Ajouter un Livre</button>
    </div>

    <!-- Table des livres -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Genre</th>
                <th>ISBN</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($livres)): ?>
                <tr>
                    <td colspan="6" class="text-center">Aucun livre trouvé.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($livres as $livre): ?>
                    <tr>
                        <td>
                            <img src="<?php echo htmlspecialchars($livre['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($livre['titre']); ?>" style="max-width: 50px; max-height: 50px;">
                        </td>
                        <td><?php echo htmlspecialchars($livre['titre']); ?></td>
                        <td><?php echo htmlspecialchars($livre['auteur']); ?></td>
                        <td><?php echo htmlspecialchars($livre['genre']); ?></td>
                        <td><?php echo htmlspecialchars($livre['isbn']); ?></td>
                        <td>
                            <!-- Bouton Modifier -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editBookModal<?php echo $livre['id']; ?>">Modifier</button>
                            <!-- Bouton Supprimer -->
                            <a href="<?php echo BASE_URL; ?>livres/delete/<?php echo $livre['id']; ?>" class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $livre['id']; ?>">Supprimer</a>
                        </td>
                    </tr>

                    <!-- Modale pour modifier un livre -->
                    <div class="modal fade" id="editBookModal<?php echo $livre['id']; ?>" tabindex="-1" aria-labelledby="editBookModalLabel<?php echo $livre['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="<?php echo BASE_URL; ?>livres/edit/<?php echo $livre['id']; ?>" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editBookModalLabel<?php echo $livre['id']; ?>">Modifier le Livre</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="titre_<?php echo $livre['id']; ?>" class="form-label">Titre</label>
                                            <input type="text" class="form-control" id="titre_<?php echo $livre['id']; ?>" name="titre" value="<?php echo htmlspecialchars($livre['titre']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="auteur_id_<?php echo $livre['id']; ?>" class="form-label">Auteur</label>
                                            <select class="form-control" id="auteur_id_<?php echo $livre['id']; ?>" name="auteur_id" required>
                                                <option value="">Sélectionner un auteur</option>
                                                <?php foreach ($auteurs as $auteur): ?>
                                                    <option value="<?php echo $auteur['id']; ?>" <?php echo $auteur['nom'] === $livre['auteur'] ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($auteur['nom']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="genre_id_<?php echo $livre['id']; ?>" class="form-label">Genre</label>
                                            <select class="form-control" id="genre_id_<?php echo $livre['id']; ?>" name="genre_id" required>
                                                <option value="">Sélectionner un genre</option>
                                                <?php foreach ($genres as $genre): ?>
                                                    <option value="<?php echo $genre['id']; ?>" <?php echo $genre['nom'] === $livre['genre'] ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($genre['nom']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="isbn_<?php echo $livre['id']; ?>" class="form-label">ISBN</label>
                                            <input type="text" class="form-control" id="isbn_<?php echo $livre['id']; ?>" name="isbn" value="<?php echo htmlspecialchars($livre['isbn']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image_<?php echo $livre['id']; ?>" class="form-label">Image (laisser vide pour ne pas modifier)</label>
                                            <input type="file" class="form-control" id="image_<?php echo $livre['id']; ?>" name="image" accept="image/*">
                                            <small class="form-text text-muted">Image actuelle : <img src="<?php echo htmlspecialchars($livre['image']); ?>" alt="Image actuelle" style="max-width: 50px; max-height: 50px;"></small>
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

<!-- Modale pour ajouter un livre -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo BASE_URL; ?>livres/add" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">Ajouter un Livre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    <div class="mb-3">
                        <label for="auteur_id" class="form-label">Auteur</label>
                        <select class="form-control" id="auteur_id" name="auteur_id" required>
                            <option value="">Sélectionner un auteur</option>
                            <?php foreach ($auteurs as $auteur): ?>
                                <option value="<?php echo $auteur['id']; ?>"><?php echo htmlspecialchars($auteur['nom']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="genre_id" class="form-label">Genre</label>
                        <select class="form-control" id="genre_id" name="genre_id" required>
                            <option value="">Sélectionner un genre</option>
                            <?php foreach ($genres as $genre): ?>
                                <option value="<?php echo $genre['id']; ?>"><?php echo htmlspecialchars($genre['nom']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
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