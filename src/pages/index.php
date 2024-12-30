<?php
// Inclusion du fichier de configuration de la base de données
include("../includes/db.php");

// Inclusion du contrôleur des recettes
include_once("../controllers/recipes.php");

// Création d'une instance de RecipesController avec la connexion à la base de données
$recipesController = new RecipesController($db);
// Récupération des dernières recettes ajoutées
$recipes = $recipesController->getLatestRecipes();
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

    <title>AjiBook</title>
</head>

<body>
    <div class="main-container">
        <!-- Inclusion de l'en-tête (header) de la page -->
        <?php include('../includes/header.php'); ?>

        <main class="main">
            <section class="section">
                <!-- Slider d'images -->
                <div class="image-slider">
                    <div class="slider-wrapper">
                        <img src="../assets/img/index_img_1.jpg" alt="Image 1" class="slider-image">
                        <img src="../assets/img/index_img_2.jpg" alt="Image 2" class="slider-image">
                        <img src="../assets/img/index_img_3.jpg" alt="Image 3" class="slider-image">
                        <img src="../assets/img/index_img_4.jpg" alt="Image 4" class="slider-image">

                    </div>
                    <button class="prev-button">❮</button>
                    <button class="next-button">❯</button>
                </div>

                <h1 class="title">Dernières recettes ajoutées</h1>
                <!-- Liste des cartes représentant les recettes -->
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
        <!-- Inclusion du pied de page (footer) de la page -->
        <?php include('../includes/footer.php'); ?>
        <div>
</body>

</html>

<style>
    /* Style pour le slider d'images */
    .image-slider {
        position: relative;
        width: 100%;
        max-width: 1200px;
        margin: 20px auto 20px;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Conteneur des images du slider */
    .slider-wrapper {
        display: flex;
        transition: transform 0.6s ease-in-out;
    }

    /* Style des images du slider */
    .slider-image {
        min-width: 100%;
        height: 300px;
        object-fit: cover;
    }

    /* Boutons de navigation du slider */
    .prev-button,
    .next-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        font-size: 20px;
        padding: 10px 15px;
        cursor: pointer;
        z-index: 10;
        border-radius: 50%;
        transition: background-color 0.3s ease;
    }

    .prev-button {
        left: 15px;
    }

    .next-button {
        right: 15px;
    }

    /* Effet de survol des boutons de navigation */
    .prev-button:hover,
    .next-button:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    /* Ajout pour les dots (indicateurs de position) */
    .slider-dots {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
    }

    /* Style de chaque dot */
    .slider-dot {
        width: 10px;
        height: 10px;
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    /* Style du dot actif */
    .slider-dot.active {
        background-color: #007bff;
    }

    /* Style de la section contenant les recettes */
    .section {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Style du titre des recettes */
    .title {
        margin-top: 24px;
    }
</style>

<script>
    // Sélection des éléments DOM
    const sliderWrapper = document.querySelector('.slider-wrapper');
    const sliderImages = document.querySelectorAll('.slider-image');
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');

    // Variables pour le slider
    let currentIndex = 0;
    const totalImages = sliderImages.length;
    const intervalTime = 5000; // Temps en ms entre les changements automatiques
    let autoSlideInterval;

    // Création des dots (indicateurs de position)
    const dotsContainer = document.createElement('div');
    dotsContainer.classList.add('slider-dots');
    sliderImages.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.classList.add('slider-dot');
        if (index === 0) dot.classList.add('active');
        dot.dataset.index = index;
        dotsContainer.appendChild(dot);
    });
    document.querySelector('.image-slider').appendChild(dotsContainer);
    const dots = document.querySelectorAll('.slider-dot');

    // Fonction pour mettre à jour le slider
    function updateSlider(index) {
        const width = sliderImages[0].clientWidth;
        sliderWrapper.style.transform = `translateX(-${index * width}px)`;
        dots.forEach(dot => dot.classList.remove('active'));
        dots[index].classList.add('active');
    }

    // Fonction pour passer à l'image suivante
    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalImages;
        updateSlider(currentIndex);
    }

    // Fonction pour revenir à l'image précédente
    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalImages) % totalImages;
        updateSlider(currentIndex);
    }

    // Boutons pour naviguer
    nextButton.addEventListener('click', () => {
        clearInterval(autoSlideInterval);
        nextSlide();
        startAutoSlide();
    });

    prevButton.addEventListener('click', () => {
        clearInterval(autoSlideInterval);
        prevSlide();
        startAutoSlide();
    });

    // Navigation avec les dots
    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            clearInterval(autoSlideInterval);
            currentIndex = parseInt(dot.dataset.index);
            updateSlider(currentIndex);
            startAutoSlide();
        });
    });

    // Changement automatique des images
    function startAutoSlide() {
        autoSlideInterval = setInterval(nextSlide, intervalTime);
    }

    // Démarrer le slider automatique
    startAutoSlide();

    // S'assurer que la taille du slider s'ajuste si la fenêtre est redimensionnée
    window.addEventListener('resize', () => updateSlider(currentIndex));
</script>