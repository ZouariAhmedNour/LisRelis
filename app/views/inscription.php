<?php include 'layouts/main.php'; ?>
<div class="container mt-5 position-relative">
    <div class="logo position-absolute top-0 start-0">
        <img src="<?php echo BASE_URL; ?>assets/images/Logo.png" alt="Lis & Relis Logo" style="height: 100px;">
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="text-center mb-4">Inscription</h1>
            <?php if (!empty($message)): ?>
                <div class="alert alert-info text-center"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form method="POST" action="" id="inscriptionForm">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="tel" class="form-control" id="telephone" name="telephone" value="<?php echo isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="mot_de_passe" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="mot_de_passe_confirm" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" id="mot_de_passe_confirm" name="mot_de_passe_confirm" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3" id="inscrireBtn">S'inscrire</button>
                <a href="/login" class="btn btn-secondary w-100" id="connecterBtn">Se connecter</a>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>js/inscription.js"></script>
<script>
    console.log("JS chargé");
</script>
</body>
</html>