<?php
// Inclusion des fichiers nécessaires pour interagir avec la base de données et les modèles
include_once("../includes/db.php");

include_once("../models/user.php");
include_once("../controllers/recipes.php");

session_start();

// Récupérer les informations de l'utilisateur stockées dans la session
$user = $_SESSION['user'];
// Vérifier si l'utilisateur est connecté (s'il n'est pas connecté, rediriger vers la page d'accueil)
if ($user == NULL) {
    header('Location: ../pages'); // Redirige vers la page d'accueil
    die(); // Arrête l'exécution du script
}

// Création d'une instance du contrôleur de recettes
$recipesControler = new RecipesController($db);
// Récupérer les recettes enregistrées dans les favoris de l'utilisateur à partir du contrôleur
$recipes = $recipesControler->getBookmarkedRecipes($user->getId());
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importation des polices -->
    <link
        href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="../assets/styles.css" />

    <title>AjiBook - Mes favoris</title>
</head>

<body>
    <div class="main-container">
        <!-- Inclusion de l'en-tête du site -->
        <?php include('../includes/header.php'); ?>

        <main class="main">
            <section class="section">
                <h1 class="title">Mes favoris</h1>
                <div class="card-list">
                    <?php foreach ($recipes as $recipe): ?>

                        <!-- Pour chaque recette, un lien vers sa page dédiée -->
                        <a href="../pages/recipe.php?id=<?= $recipe->getId() ?>" class="card-item">
                            <img src=<?= $recipe->getImageUrl() ?> alt="Card Image">
                            <span class="<?= $recipe->getCategory() ?>"><?= $recipe->getTranslatedCategory() ?></span>
                            <h3><?= $recipe->getTitle() ?> </h3>
                        </a>

                    <?php endforeach ?>
                </div>
            </section>
        </main>

        <!-- Inclusion du pied de page -->
        <?php include('../includes/footer.php'); ?>
    </div>
</body>

</html>