<?php include 'layouts/main.php'; ?>
<div class="container mt-5">
    <div class="logo mb-4">
        <img src="<?php echo BASE_URL; ?>assets/images/Logo.png" alt="Logo" style="height: 80px;">
    </div>

    <nav class="mb-4">
        <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Livres</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Auteurs</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Genres</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Mon Compte</a></li>
            <li class="nav-item"><a href="<?php echo BASE_URL; ?>logout" class="btn btn-danger float-end">Se déconnecter</a></li>
        </ul>
    </nav>
    <?php if (isset($_SESSION['user_nom'])): ?>
    <div class="alert alert-success">
        Bienvenue, <?php echo htmlspecialchars($_SESSION['user_nom']); ?> !
    </div>
<?php endif; ?>

    <div class="mb-4">
        <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Rechercher un livre..." aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Rechercher</button>
        </form>
    </div>

    <h2>Livres Populaires</h2>
    <div class="row">
        <?php foreach ($livresPopulaires as $livre): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo $livre['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($livre['titre']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($livre['titre']); ?></h5>
                        <p class="card-text">Auteur : <?php echo htmlspecialchars($livre['auteur']); ?></p>
                        <a href="#" class="btn btn-primary">Voir Plus</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
