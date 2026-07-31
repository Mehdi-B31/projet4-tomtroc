<h2>Connexion</h2>

<form action="index.php?action=login_submit" method="post">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
    </div>
    <button type="submit">Se connecter</button>
</form>

<p>Pas encore inscrit ? <a href="index.php?action=register">Inscrivez-vous</a></p>