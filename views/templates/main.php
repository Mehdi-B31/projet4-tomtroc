<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TomTroc</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>TomTroc</h1>
        <nav>
            <a href="index.php?action=home">Accueil</a>
            <?php if (isset($_SESSION['user'])) : ?>
                <a href="index.php?action=logout">Déconnexion</a>
            <?php else : ?>
                <a href="index.php?action=login">Connexion</a>
                <a href="index.php?action=register">Inscription</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <?php require $content; ?>
    </main>

    <footer>
        <p>TomTroc - Echangez vos livres</p>
    </footer>
</body>
</html>