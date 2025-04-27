<div class="container mt-5">
    <div class="d-flex align-items-center justify-content-between">
        <!-- Logo à gauche -->
        <div class="logo">
            <img src="<?php echo BASE_URL; ?>assets/images/Logo.png" alt="Logo" style="height: 80px;">
        </div>

        <!-- Menu à droite -->
        <nav>
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'accueil' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>accueil">Accueil</a></li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 0): ?>
                    <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'livres' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>livres">Livres</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'auteurs' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>auteurs">Auteurs</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'genres' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>genres">Genres</a></li>
                <?php endif; ?>
                <li class="nav-item">
                    <?php
                    // Débogage : Vérifier si la session existe
                    if (!isset($_SESSION['user'])) {
                        echo "<!-- Débogage : Utilisateur non connecté, session non définie -->";
                    } else {
                        echo "<!-- Débogage : Utilisateur connecté, rôle = " . htmlspecialchars($_SESSION['user']['role']) . " -->";
                        if ($_SESSION['user']['role'] == 0) {
                            echo '<a class="nav-link ' . ($currentPage === 'profilAdmin' ? 'active' : '') . '" href="' . BASE_URL . 'profilAdmin">Mon Compte</a>';
                        } else {
                            echo '<a class="nav-link ' . ($currentPage === 'profil' ? 'active' : '') . '" href="' . BASE_URL . 'profil">Mon Compte</a>';
                        }
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <!-- Bouton Mode Sombre sera ajouté ici via JS -->
                    <span id="dark-mode-placeholder"></span>
                </li>
                <li class="nav-item"><a href="<?php echo BASE_URL; ?>logout" class="btn btn-danger">Se déconnecter</a></li>
            </ul>
        </nav>
    </div>

    <div class="welcome-message mt-3">
        <p id="welcome-text"></p>
    </div>
</div>