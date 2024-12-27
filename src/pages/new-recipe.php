<?php
include_once("../includes/db.php");

include_once("../controllers/recipes.php");
include_once('../models/user.php');

session_start();
$user = $_SESSION['user'];
if ($user == NULL) {
    header('Location: ../pages');
    die();
}

$recipesController = new RecipesController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $category = $_POST['category'];
    $usersId = $user->getId();

    $extension = explode('.', $_FILES['imageUpload']['name'])[1];
    $path = '../uploads/' . basename(md5($_FILES['imageUpload']['tmp_name'])) . '.' . $extension;
    move_uploaded_file($_FILES['imageUpload']['tmp_name'], $path);

    $recipe = new Recipe(0, $title, $ingredients, $instructions, $category, 0, $path, $usersId);
    $id = $recipesController->save($recipe);

    header('Location: ../pages/recipe.php?id=' . $id);
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

    <title>AjiBook - Créer une recette</title>
</head>

<body>
    <div class="main-container">
        <?php include('../includes/header.php'); ?>

        <main class="main">
            <form id="recipeForm" method="POST" enctype="multipart/form-data">
                <div class="form-left">
                    <div class="form-group">
                        <label for="title">Titre :</label>
                        <input type="text" id="title" name="title" placeholder="Titre de la recette" required>
                    </div>
                    <div class="form-group">
                        <div>Catégorie :</div>
                        <div class="categories">
                            <fieldset class="category">
                                <label for="appetizer">Apéritif</label>
                                <input type="radio" name="category" value="appetizer" id="appetizer">
                            </fieldset>
                            <fieldset class="category">
                                <label for="starter">Entrée</label>
                                <input type="radio" name="category" value="starter" id="starter">
                            </fieldset>
                            <fieldset class="category">
                                <label for="main-course">Plat</label>
                                <input type="radio" name="category" value="main-course" id="main-course">
                            </fieldset>
                            <fieldset class="category">
                                <label for="desert">Dessert</label>
                                <input type="radio" name="category" value="desert" id="desert">
                            </fieldset>
                            <fieldset class="category">
                                <label for="drink">Boisson</label>
                                <input type="radio" name="category" value="drink" id="drink">
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ingredients">Ingrédients :</label>
                        <input type="text" id="ingredients" name="ingredients" placeholder="Ex : 2 œufs, 100g de sucre" required>
                    </div>
                    <div class="form-group image-upload">
                        <label for="imageUpload">Téléverser une image :</label>
                        <div class="image-placeholder">
                            <input type="file" id="imageUpload" name="imageUpload" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="form-right">
                    <div class="form-group">
                        <label for="instructions">Recette :</label>
                        <textarea id="instructions" name="instructions" placeholder="Décrivez les étapes de la recette ici..." rows="10" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Publier</button>
                </div>
            </form>
        </main>

        <?php include('../includes/footer.php'); ?>
    </div>
</body>

</html>

<style>
    :root {
        --background-color: #f8f8f8;
        --container-bg-color: #ffffff;
        --text-color: #333;
        --label-color: #555;
        --input-border-color: #ccc;
        --input-focus-color: #ebb22f;
        --button-bg-color: #ebb22f;
        --button-hover-bg-color: #e49f00;
        --button-text-color: #fff;
        --category-bg-color: #f0f0f0;
        --category-hover-bg-color: #ebb22f;
        --category-hover-text-color: #fff;
        --image-placeholder-bg: #f0f0f0;
        --image-placeholder-border: #ccc;
        --image-placeholder-hover-border: #ebb22f;
    }

    #recipeForm {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        background: #fff;
        margin: 0 auto;
        max-width: 1200px;
        padding: 12px 24px;
        margin-top: 24px;
    }

    #recipeForm h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 1.8em;
        font-weight: bold;
        color: var(--text-color);
    }

    .form-left,
    .form-right {
        flex: 1;
    }

    .form-group {
        margin-bottom: 20px;
    }

    #recipeForm label {
        display: block;
        font-weight: bold;
        font-size: 1em;
        color: var(--label-color);
    }

    #recipeForm input,
    #recipeForm textarea,
    #recipeForm button {
        width: 100%;
        padding: 10px;
        font-size: 1em;
        border: 1px solid var(--input-border-color);
        border-radius: 5px;
        outline: none;
    }

    #recipeForm input:focus,
    #recipeForm textarea:focus {
        border-color: var(--input-focus-color);
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    #recipeForm textarea {
        resize: none;
    }

    .categories {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Style des boutons de catégorie */
    .category {
        background-color: var(--category-bg-color);
        border: 1px solid var(--input-border-color);
        border-radius: 5px;
        font-size: 0.9em;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
        text-align: center;
    }

    .category input {
        display: none;
    }

    .category label {
        padding: 8px 12px;
        cursor: pointer;
        user-select: none;
    }

    /* Style au survol (hover) */
    .category:hover {
        background-color: var(--category-hover-bg-color);
        color: var(--category-hover-text-color);
    }

    /* Style de la catégorie sélectionnée */
    .category:has(input:checked) {
        background-color: var(--category-hover-bg-color);
        /* Même couleur que le hover */
        color: var(--category-hover-text-color);
        /* Même couleur de texte que le hover */
        border-color: var(--input-focus-color);
        /* Optionnel pour changer la bordure */
    }

    .image-placeholder {
        width: 100%;
        height: 120px;
        background: var(--image-placeholder-bg);
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 5px;
        cursor: pointer;
        border: 2px dashed var(--image-placeholder-border);
        transition: 0.3s;
    }

    .image-placeholder:hover {
        border-color: var(--image-placeholder-hover-border);
    }

    .submit-btn {
        background-color: var(--button-bg-color);
        color: var(--button-text-color);
        font-weight: bold;
        border: none;
        cursor: pointer;
        padding: 12px;
        border-radius: 5px;
        transition: 0.3s;
        width: 100%;
    }

    .submit-btn:hover {
        background-color: var(--button-hover-bg-color);
    }
</style>