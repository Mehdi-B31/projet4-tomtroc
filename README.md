## TomTroc

Plateforme d'échange de livres entre particuliers, développée en PHP natif selon une architecture MVC, sans framework.

## Pour utiliser ce projet :

- Commencez par cloner le projet.
- Installez le projet chez vous, dans un dossier exécuté par un serveur local (type MAMP, WAMP, LAMP, Herd, etc...)
- Une fois installé chez vous, créez une base de données vide appelée : "tomtroc"
- Importez le fichier _tomtroc.sql_ dans votre base de données.

## Lancez le projet !

Pour la configuration du projet, renommez le fichier _\_config.php_ (dans le dossier _config_) en _config.php_ et éditez-le si nécessaire.
Ce fichier contient notamment les informations de connexion à la base de données.

Pour tester le site, vous pouvez créer un compte directement via la page d'inscription, ou utiliser un des comptes de démonstration présents dans le fichier SQL.

## Structure du projet :

- **config/** : configuration de la base de données et autoloader
- **controllers/** : contrôleurs (HomeController, UserController, BookController, MessageController)
- **models/** : gestion des données via PDO (DBManager, AbstractEntityManager, UserManager, BookManager, ConversationManager, MessageManager)
- **views/** : template principal et vues de chaque page
- **css/** : feuille de style
- **assets/images/** : images du site (livres, avatars, visuels)

## Problèmes courants :

Le dossier _assets/images/books/_ doit disposer des droits d'écriture pour que l'upload des photos de livres fonctionne.

Ce projet a été réalisé avec PHP 8.2. Bien que d'autres versions de PHP puissent fonctionner, il n'est pas garanti que le projet fonctionne avec des versions antérieures.

## Copyright :

Projet réalisé dans le cadre d'une formation OpenClassrooms.
