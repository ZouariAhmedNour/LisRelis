<?php
// Définir la page actuelle
$currentPage = 'accueil';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container">
    <?php if (isset($_SESSION['user_nom'])): ?>
        <div class="alert alert-success">
            Bienvenue, <?php echo htmlspecialchars($_SESSION['user_nom']); ?> !
        </div>
    <?php endif; ?>

    <div class="mb-4">
        <form class="d-flex" method="GET" action="">
            <input class="form-control me-2" type="search" name="search" placeholder="Rechercher un livre..." aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="btn btn-outline-primary" type="submit">Rechercher</button>
        </form>
    </div>

    <?php if (!empty($livresRecherches)): ?>
        <h2>Résultats de la recherche</h2>
        <div class="row search-results">
            <?php foreach ($livresRecherches as $livre): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($livre['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($livre['titre']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($livre['titre']); ?></h5>
                            <p class="card-text">Auteur : <?php echo htmlspecialchars($livre['auteur']); ?></p>
                            <p class="card-text">Genre : <?php echo htmlspecialchars($livre['genre']); ?></p>
                            <!-- Indication de disponibilité -->
                            <p class="card-text">
                                <span class="badge <?php echo $livre['disponible'] == 1 ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo $livre['disponible'] == 1 ? 'Disponible' : 'Non disponible'; ?>
                                </span>
                            </p>
                            <a href="<?php echo BASE_URL; ?>detailsLivre/<?php echo $livre['id']; ?>" class="btn btn-primary">Voir Plus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h2>Livres Populaires</h2>
    <div class="row popular-books">
        <?php foreach ($livresPopulaires as $livre): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo htmlspecialchars($livre['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($livre['titre']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($livre['titre']); ?></h5>
                        <p class="card-text">Auteur : <?php echo htmlspecialchars($livre['auteur']); ?></p>
                        <p class="card-text">Genre : <?php echo htmlspecialchars($livre['genre']); ?></p>
                        <!-- Indication de disponibilité -->
                        <p class="card-text">
                            <span class="badge <?php echo $livre['disponible'] == 1 ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo $livre['disponible'] == 1 ? 'Disponible' : 'Non disponible'; ?>
                            </span>
                        </p>
                        <a href="<?php echo BASE_URL; ?>detailsLivre/<?php echo $livre['id']; ?>" class="btn btn-primary">Voir Plus</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>