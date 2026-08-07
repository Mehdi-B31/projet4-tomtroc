<div class="auth-page">
    <div class="auth-form-side">
        <h1 class="auth-title">Inscription</h1>

        <form action="index.php?action=register_submit" method="post" class="auth-form">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary auth-submit-btn">S'inscrire</button>
        </form>

        <p class="form-link">Déjà inscrit ? <a href="index.php?action=login">Connectez-vous</a></p>
    </div>

    <div class="auth-image-side"></div>
</div>