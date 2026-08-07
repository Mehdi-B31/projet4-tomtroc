<div class="auth-page">
    <div class="auth-form-side">
        <h1 class="auth-title">Connexion</h1>

        <form action="index.php?action=login_submit" method="post" class="auth-form">
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary auth-submit-btn">Se connecter</button>
        </form>

        <p class="form-link">Pas de compte ? <a href="index.php?action=register">Inscrivez-vous</a></p>
    </div>

    <div class="auth-image-side"></div>
</div>