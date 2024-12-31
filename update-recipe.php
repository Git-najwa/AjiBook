<?php

require_once('./config/autoload.php');

use ch\comem\DB;
use ch\comem\controllers\RecipesController;
use ch\comem\models\Recipe;

$db = new DB();

session_start();

// Vérification si l'utilisateur est connecté
$user = $_SESSION['user'];
if ($user == NULL) {
    header('Location: ./');
    die();
}

$id = $_GET['id'];

// Création d'une instance du contrôleur de recettes
$recipesController = new RecipesController($db);

$recipe = $recipesController->getById($id);

// Traitement du formulaire lorsqu'une requête POST est reçu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données envoyées par le formulaire
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $category = $_POST['category'];
    $usersId = $user->getId();

    $path = $recipe->getImageUrl();
    if ($_FILES['imageUpload']['size'] != 0) {
        // Traitement de l'image téléchargée
        $extension = explode('.', $_FILES['imageUpload']['name'])[1];
        $path = './uploads/' . basename(md5($_FILES['imageUpload']['tmp_name'])) . '.' . $extension;
        move_uploaded_file($_FILES['imageUpload']['tmp_name'], $path);
    }

    // Création d'une nouvelle instance de la recette avec les données soumises
    $recipe = new Recipe($id, $title, $ingredients, $instructions, $category, 0, $path, $usersId);
    // Sauvegarde de la recette dans la base de données
    $recipesController->update($recipe);
    // Redirection vers la page de la recette après l'enregistrement
    header('Location: ./recipe.php?id=' . $id);
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

    <link rel="stylesheet" href="./assets/styles.css" />

    <title>AjiBook - Modifier la recette</title>
</head>

<body>
    <div class="main-container">
        <!-- Inclusion de l'en-tête -->
        <?php include('./includes/header.php'); ?>

        <main class="main">
            <h1 class="title">Modifier la recette</h1>
            <!-- Formulaire de création de recette -->
            <form id="recipeForm" method="POST" enctype="multipart/form-data">
                <div class="form-left">
                    <div class="form-group">
                        <label for="title">Titre :</label>
                        <input type="text" id="title" name="title" placeholder="Titre de la recette" value="<?= $recipe->getTitle() ?>" required>
                    </div>
                    <div class="form-group">
                        <!-- Choix de la catégorie de la recette -->
                        <div>Catégorie :</div>
                        <div class="categories">
                            <fieldset class="category">
                                <label for="appetizer">Apéritif</label>
                                <input type="radio" name="category" value="appetizer" id="appetizer" <?= $recipe->getCategory() == "appetizer" ? "checked" : "" ?>>
                            </fieldset>
                            <fieldset class="category">
                                <label for="starter">Entrée</label>
                                <input type="radio" name="category" value="starter" id="starter" <?= $recipe->getCategory() == "starter" ? "checked" : "" ?>>
                            </fieldset>
                            <fieldset class="category">
                                <label for="main-course">Plat</label>
                                <input type="radio" name="category" value="main-course" id="main-course" <?= $recipe->getCategory() == "main-course" ? "checked" : "" ?>>
                            </fieldset>
                            <fieldset class="category">
                                <label for="desert">Dessert</label>
                                <input type="radio" name="category" value="desert" id="desert" <?= $recipe->getCategory() == "desert" ? "checked" : "" ?>>
                            </fieldset>
                            <fieldset class="category">
                                <label for="drink">Boisson</label>
                                <input type="radio" name="category" value="drink" id="drink" <?= $recipe->getCategory() == "drink" ? "checked" : "" ?>>
                            </fieldset>
                        </div>
                    </div>
                    <!-- Ingrédients de la recette -->
                    <div class="form-group">
                        <label for="ingredients">Ingrédients :</label>
                        <input type="text" id="ingredients" name="ingredients" placeholder="Ex : 2 œufs, 100g de sucre" value="<?= $recipe->getIngredients() ?>" required>
                    </div>
                    <!-- Téléversement de l'image de la recette -->
                    <div class="form-group image-upload">
                        <label for="imageUpload">Téléverser une image :</label>
                        <div class="image-placeholder">
                            <input type="file" id="imageUpload" name="imageUpload" accept="image/*">
                        </div>
                    </div>
                </div>
                <!-- Instructions de la recette -->
                <div class="form-right">
                    <div class="form-group">
                        <label for="instructions">Recette :</label>
                        <textarea id="instructions" name="instructions" placeholder="Décrivez les étapes de la recette ici..." rows="10" required><?= $recipe->getInstructions() ?></textarea>
                    </div>
                    <!-- Bouton de soumission -->
                    <button type="submit" class="submit-btn">Modifier</button>
                </div>
            </form>
        </main>

        <!-- Inclusion du pied de page -->
        <?php include('./includes/footer.php'); ?>
    </div>
</body>

</html>

<style>
    /* Définition des variables de couleurs pour le design */
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

    /* Style du formulaire de création de recette */
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