<?php
include_once("../includes/db.php");

include_once("../controllers/recipes.php");

$recipesController = new RecipesController($db);
$recipes = $recipesController->getByCategory('appetizer');
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

    <title>AjiBook - Apéritifs</title>
</head>

<body>
    <div class="main-container">
        <?php include('../includes/header.php'); ?>

        <main class="main">
            <section class="section">
                <h1 class="title">Recettes appéritif ou buffet</h1>
                <div class="card-list">
                    <?php foreach ($recipes as $recipe): ?>

                        <a href="../pages/recipe.php?id=<?= $recipe->getId() ?>" class="card-item">
                            <img src=<?= $recipe->getImageUrl() ?> alt="Card Image">
                            <span class="<?= $recipe->getCategory() ?>"><?= $recipe->getTranslatedCategory() ?></span>
                            <h3><?= $recipe->getTitle() ?> </h3>
                        </a>

                    <?php endforeach ?>
                </div>
            </section>
        </main>

        <?php include('../includes/footer.php'); ?>
    </div>
</body>

</html>