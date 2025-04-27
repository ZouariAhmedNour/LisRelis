<?php
// Définir la page actuelle
$currentPage = 'auteurs';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container mt-5">
    <h1>Gestion des Auteurs</h1>

    <!-- Afficher les messages de succès s'il y en a -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <p><?php echo htmlspecialchars($_SESSION['success']); ?></p>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Afficher les messages d'erreur s'il y en a -->
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <!-- Bouton pour ajouter un auteur -->
    <div class="mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAuthorModal">Ajouter un Auteur</button>
    </div>

    <!-- Table des auteurs -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Biographie</th>
                <th>Date de Naissance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($auteurs)): ?>
                <tr>
                    <td colspan="4" class="text-center">Aucun auteur trouvé.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($auteurs as $auteur): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($auteur['nom']); ?></td>
                        <td><?php echo htmlspecialchars($auteur['biographie']); ?></td>
                        <td><?php echo htmlspecialchars($auteur['date_de_naissance']); ?></td>
                        <td>
                            <!-- Bouton Modifier -->
                            <button class="btn btn-sm btn-warning edit-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editAuthorModal" 
                                    data-id="<?php echo $auteur['id']; ?>" 
                                    data-nom="<?php echo htmlspecialchars($auteur['nom']); ?>" 
                                    data-biographie="<?php echo htmlspecialchars($auteur['biographie']); ?>" 
                                    data-date-de-naissance="<?php echo htmlspecialchars($auteur['date_de_naissance']); ?>">
                                Modifier
                            </button>
                            <!-- Bouton Supprimer -->
                            <a href="<?php echo BASE_URL; ?>auteurs/delete/<?php echo $auteur['id']; ?>" 
                               class="btn btn-sm btn-danger delete-btn" 
                               data-id="<?php echo $auteur['id']; ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modale pour ajouter un auteur -->
<div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo BASE_URL; ?>auteurs/add">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAuthorModalLabel">Ajouter un Auteur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="biographie" class="form-label">Biographie</label>
                        <textarea class="form-control" id="biographie" name="biographie" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date_de_naissance" class="form-label">Date de Naissance</label>
                        <input type="date" class="form-control" id="date_de_naissance" name="date_de_naissance" required>
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

<!-- Modale pour modifier un auteur -->
<div class="modal fade" id="editAuthorModal" tabindex="-1" aria-labelledby="editAuthorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo BASE_URL; ?>auteurs/edit">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAuthorModalLabel">Modifier un Auteur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_author_id" name="id">
                    <div class="mb-3">
                        <label for="edit_nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="edit_nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_biographie" class="form-label">Biographie</label>
                        <textarea class="form-control" id="edit_biographie" name="biographie" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_date_de_naissance" class="form-label">Date de Naissance</label>
                        <input type="date" class="form-control" id="edit_date_de_naissance" name="date_de_naissance" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Pré-remplir la modale de modification avec les données de l'auteur
document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const nom = button.getAttribute('data-nom');
            const biographie = button.getAttribute('data-biographie');
            const dateDeNaissance = button.getAttribute('data-date-de-naissance');

            // Pré-remplir les champs de la modale
            document.getElementById('edit_author_id').value = id;
            document.getElementById('edit_nom').value = nom;
            document.getElementById('edit_biographie').value = biographie;
            document.getElementById('edit_date_de_naissance').value = dateDeNaissance;
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