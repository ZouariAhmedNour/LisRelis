<?php include 'layouts/main.php'; ?>
<div class="container mt-5 position-relative">
    <div class="logo position-absolute top-0 start-0">
        <img src="<?php echo BASE_URL; ?>assets/images/Logo.png" alt="Lis & Relis Logo" style="height: 100px;">
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="text-center mb-4">Connexion</h1>
            <form method="POST" action="http://localhost/lisrelis/public/login" id="loginForm">
                <?php if (!empty($message)): ?>
    <div id="login-error" class="alert alert-danger" style="display: none;">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>



                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">Se connecter</button>
                <div class="text-center">
                    <a href="/forgot-password" class="text-decoration-none" style="color: #2C1B2E;">Mot de passe oublié ?</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>js/login.js"></script>

</body>
</html>