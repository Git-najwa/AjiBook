<?php

require_once('./config/autoload.php');

use ch\comem\DB;
use ch\comem\controllers\RecipesController;

$db = new DB();

// Création d'une instance du contrôleur RecipesController avec la connexion à la base de données
$recipesController = new RecipesController($db);
// Récupération des recettes de la catégorie "appetizer" (apéritifs)
$recipes = $recipesController->getByCategory('main-course');
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

    <link rel="stylesheet" href="./assets/styles.css" />

    <title>AjiBook - Plats principaux</title>
</head>

<body>
    <div class="main-container">
        <!-- Inclusion du fichier d'en-tête (header) -->
        <?php include('./includes/header.php'); ?>

        <main class="main">
            <section class="section">
                <h1 class="title">Recettes plats principaux</h1>
                <div class="card-list">
                    <?php foreach ($recipes as $recipe): ?>

                        <a href="./recipe.php?id=<?= $recipe->getId() ?>" class="card-item">
                            <img src=<?= $recipe->getImageUrl() ?> alt="Card Image">
                            <span class="<?= $recipe->getCategory() ?>"><?= $recipe->getTranslatedCategory() ?></span>
                            <h3><?= $recipe->getTitle() ?> </h3>
                        </a>

                    <?php endforeach ?>
                </div>
            </section>
        </main>

        <!-- Inclusion du fichier de pied de page (footer) -->
        <?php include('./includes/footer.php'); ?>
    </div>
</body>

</html>