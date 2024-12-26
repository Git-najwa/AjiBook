<?php
include_once("../includes/db.php");

include_once("../models/user.php");

include_once("../controllers/recipes.php");
include_once("../controllers/users.php");
include_once("../controllers/bookmarks.php");

$id = $_GET['id'];

$recipesController = new RecipesController($db);
$usersController = new UsersController($db);
$bookmarksController = new BookmarksController($db);

$recipe = $recipesController->getById($id);
$user = $usersController->getById($recipe->getUsersId());

session_start();
$userSession = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($userSession == NULL) {
        header('Location: ../pages');
        die();
    }

    $bookmark = new Bookmark(0, 0, $recipe->getId(), $userSession->getId());
    $bookmarksController->save($bookmark);
}

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
                    <div class="title-bar">
                        <h1><?= $recipe->getTitle() ?></h1>
                        <? if ($userSession != null): ?>
                            <form method="POST" action="../pages/recipe.php?id=<?= $recipe->getId() ?>">
                                <button class="bookmark-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart">
                                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                    </svg>
                                </button>
                            </form>
                        <? endif ?>
                    </div>
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

    .title-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .bookmark-button {
        background: none;
        border: none;
        cursor: pointer;
    }

    .bookmark-button:hover svg {
        color: red;
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
        padding-right: 50px;
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