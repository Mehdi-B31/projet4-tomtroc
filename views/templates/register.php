<h2>Inscription</h2>

<form action="index.php?action=register_submit" method="post">
    <div>
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" required>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
    </div>
    <button type="submit">S'inscrire</button>
</form>

<p>Déjà inscrit ? <a href="index.php?action=login">Connectez-vous</a></p>