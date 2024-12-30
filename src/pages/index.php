<?php
include("../includes/db.php");

include_once("../controllers/recipes.php");

$recipesController = new RecipesController($db);
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
        <?php include('../includes/header.php'); ?>

        <main class="main">
            <section class="section">
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
                <div class="card-list">
                    <?php foreach ($recipes as $recipe): ?>

                        <a href="../pages/recipe.php?id=<?= $recipe->getId() ?>" class="card-item">
                            <img src="../assets/img/acrademorue.jpg" alt="Card Image">
                            <span class="<?= $recipe->getCategory() ?>"><?= $recipe->getTranslatedCategory() ?></span>
                            <h3><?= $recipe->getTitle() ?> </h3>
                        </a>

                    <?php endforeach ?>
                </div>
            </section>
        </main>

        <?php include('../includes/footer.php'); ?>
        <div>
</body>

</html>

<style>
    .image-slider {
        position: relative;
        width: 100%;
        max-width: 1200px;
        margin: 20px auto 20px;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .slider-wrapper {
        display: flex;
        transition: transform 0.6s ease-in-out;
    }

    .slider-image {
        min-width: 100%;
        height: 300px;
        object-fit: cover;
    }

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

    .slider-dot {
        width: 10px;
        height: 10px;
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .slider-dot.active {
        background-color: #007bff;
    }


    .section {
        max-width: 1200px;
        margin: 0 auto;
    }

    .title {
        margin-top: 24px;
    }
</style>

<script>
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

    function updateSlider(index) {
        const width = sliderImages[0].clientWidth;
        sliderWrapper.style.transform = `translateX(-${index * width}px)`;
        dots.forEach(dot => dot.classList.remove('active'));
        dots[index].classList.add('active');
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalImages;
        updateSlider(currentIndex);
    }

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