# AJIBOOK

## Description du projet :

AjiBook est une application web permettant aux utilisateurs de créer un compte, se connecter et gérer leurs recettes de cuisine. Chaque utilisateur peut ajouter, modifier, et supprimer ses propres recettes et marquer d’autres recettes comme favorites. Les recettes sont visibles dans un espace commun, triées par catégories (sucré, salé, dessert, apéro, etc.) pour faciliter la recherche.

## Technologies utilisées :

- HTML
- CSS
- JS
- PHP
- SQlite

## Fonctionnalités

- Inscription des utilisateurs
- Envoi d'email de confirmation d'inscription
- Création, affichage et gestion des recettes
- Ajout des recettes aux favoris
- Système de gestion des erreurs et validation des formulaires

## Structure du projet

Le projet est divisé en plusieurs composants principaux :

### 1. **Inclusions des fichiers nécessaires**

Les fichiers principaux sont inclus au début de chaque page PHP pour permettre la connexion à la base de données et la gestion des utilisateurs.

Les différentes classes se chargent grâce à un autoload.

- `db.php` : Gère la connexion à la base de données.
- `user.php` : Contient la classe `User` pour gérer les utilisateurs.
- `users.php` : Contient le contrôleur `UsersController` pour la gestion des utilisateurs (récupération, enregistrement, etc.).
- `recipes.php` : Contient le contrôleur `RecipesController` pour la gestion des recettes.
- `bookmarks.php` : Contient le contrôleur `BookmarksController` pour la gestion des favoris.

### 2. **Formulaire d'inscription**

Le formulaire d'inscription permet à un utilisateur de créer un compte en renseignant un nom d'utilisateur, un email et un mot de passe.

- **Processus d'inscription** : Lors de la soumission du formulaire, les données sont validées. Si l'un des champs est vide, un message d'erreur est affiché. Si le nom d'utilisateur existe déjà, un autre message d'erreur est affiché.

### 3. **Page de recette**

La page de recette affiche une recette spécifique avec son titre, son image, ses ingrédients, et ses instructions. L'utilisateur peut ajouter ou retirer la recette de ses favoris en cliquant sur un bouton.

- **Vérification des favoris** : Lorsqu'un utilisateur est connecté, l'application vérifie s'il a déjà ajouté la recette aux favoris. Si oui, le bouton devient rouge.

### 4. **Favoris (Bookmarks)**

Les utilisateurs peuvent ajouter des recettes à leurs favoris. Les favoris sont associés à l'utilisateur et sauvegardés dans la base de données.
