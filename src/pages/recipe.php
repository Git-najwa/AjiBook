<?php
include_once("../includes/db.php");

include_once("../controllers/recipes.php");
include_once("../controllers/users.php");

$id = $_GET['id'];

$recipesController = new RecipesController($db);
$usersController = new UsersController($db);

$recipe = $recipesController->getById($id);
$user = $usersController->getById($recipe->getUsersId());

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

    <title>AjiBook - <?= $recipe->getTitle() ?></title>
</head>

<body>
    <div class="main-container">
        <?php include('../includes/header.php'); ?>

        <main class="main">
            <div id="main-container">
                <div id="image-container">
                    <img
                        src="../assets/img/acrademorue.jpg"
                        alt="<?= $recipe->getTitle() ?>" />
                </div>

                <!-- Contenu recette -->
                <div id="recipe-content">
                    <h1><?= $recipe->getTitle() ?></h1>
                    <div id="tags">
                        <span id="category"><?= $recipe->getTranslatedCategory() ?></span>
                        <span id="author">Créé par : <?= $user->getUsername() ?></span>
                    </div>

                    <!-- Ingrédients -->
                    <div id="ingredients">
                        <h2>Ingrédients</h2>
                        <p>
                            <?= $recipe->getIngredients() ?>
                        </p>
                    </div>
                </div>
            </div>

            <div id="recipe-details">
                <h2>Recette</h2>
                <p>
                    <?= $recipe->getInstructions() ?>
                </p>
            </div>
        </main>

        <?php include('../includes/footer.php'); ?>
    </div>
</body>

</html>

<style>
    #main-container {
        display: flex;
        margin: 30px;
    }

    #image-container {
        display: flex;
        flex: 1;
    }

    #image-container img {
        object-fit: cover;
        max-width: 600px;
        /* Retire toute limite maximale éventuelle */
        display: block;
        /* Centre l'image horizontalement */
        margin-left: 30px;
    }

    #tags {
        display: flex;
    }

    #tags #category {
        margin-right: 20px;
        color: white;
        background-color: black;
        padding-top: 6px;
        padding-bottom: 6px;
        padding-left: 15px;
        padding-right: 15px;
        border-radius: 5px;
    }

    #tags #author {
        margin-top: 7px;
    }

    #recipe-content {
        flex: 1;
        background: #fff;
        margin-left: 100px;
        padding-top: 20px;
        padding-left: 50px;
        margin-right: 50px;
        padding-bottom: 50px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    #recipe-content h1 {
        padding-top: 10px;
        font-size: 2.5em;
        margin-bottom: 10px;
    }

    #category,
    #author {
        display: block;
        font-size: 1.1em;
        color: #666;
        margin-bottom: 20px;
    }

    #recipe-details {
        margin-left: 50px;
        margin-right: 50px;
    }

    #ingredients h2,
    #recipe-details h2 {
        font-size: 2em;
        font-weight: 550;
        margin-bottom: 10px;
        color: #000;
    }

    #ingredients ul {
        list-style: disc;
        margin-left: 20px;
        margin-bottom: 0px;
    }

    #ingredients ul li {
        font-size: 1.1em;
    }

    #recipe-details p {
        text-align: justify;
        margin: 30px 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        #recipe {
            flex-direction: column;
        }

        #nav ul {
            flex-direction: column;
            align-items: center;
        }
    }
</style>