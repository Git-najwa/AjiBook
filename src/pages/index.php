<?php
    include("../includes/db.php");

    include_once("../controllers/recipes.php");

    $recipesController = new RecipesController($db);
    $recipes = $recipesController->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <!-- Importation des polices -->
    <link
      href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="../assets/styles.css" />
    
    <title>AjiBook</title>
</head>
<body>
    <div class="main-container">
        <?php include('../includes/header.php'); ?>

        <main class="main">  
        
        </main>

        <?php include('../includes/footer.php'); ?>
    <div>
</body>

</html>
