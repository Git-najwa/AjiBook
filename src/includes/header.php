<?php

// Récupération de l'URL de la requête
$requestUrl = $_SERVER['REQUEST_URI'];

// Démarrage de la session utilisateur
session_start();
// Récupération des informations de l'utilisateur connecté depuis la session
if (isset($_SESSION['user'])) {
    $userSession = $_SESSION['user'];
} else {
    $userSession = null;
}

?>

<!-- Barre supérieure -->
<div class="top-bar">
    <a class="logo" href="./">
        <img src="./assets/img/logo.png" alt="Logo" />
    </a>

    <? if ($userSession == null): ?>
        <div class="login-button">
            <a href="./login.php">Connexion</a>
        </div>
    <? else: ?>
        <div class="dropdown">
            <button onclick="openDropdown()" class="dropbtn"><?= $userSession ? $userSession->getUsername() : "" ?></button>
            <div id="dropdown" class="dropdown-content">
                <a href="./new-recipe.php">Nouvelle recette</a>
                <a href="./my-recipes.php">Mes recettes</a>
                <a href="./my-bookmarks.php">Mes favoris</a>
                <a href="./logout.php">Déconnexion</a>
            </div>
        </div>
    <? endif ?>
</div>

<!-- Barre de menu -->
<nav class="menu">
    <ul>
        <li>
            <a href="./aperitifs.php" class="<?= str_ends_with($requestUrl, "aperitifs.php") ? 'selected-item' : '' ?>">Apéritifs</a>
        </li>
        <li>
            <a href="./entrees.php" class="<?= str_ends_with($requestUrl, "entrees.php") ? 'selected-item' : '' ?>">Entrées</a>
        </li>
        <li>
            <a href="./plats.php" class="<?= str_ends_with($requestUrl, "plats.php") ? 'selected-item' : '' ?>">Plats</a>
        </li>
        <li>
            <a href="./desserts.php" class="<?= str_ends_with($requestUrl, "desserts.php") ? 'selected-item' : '' ?>">Desserts</a>
        </li>
        <li>
            <a href="./boissons.php" class="<?= str_ends_with($requestUrl, "boissons.php") ? 'selected-item' : '' ?>">Boissons</a>
        </li>
    </ul>
</nav>

<script>
    /**
     * Fonction pour afficher ou masquer le menu déroulant lorsque l'utilisateur clique sur le bouton.
     */
    function openDropdown() {
        document.getElementById("dropdown").classList.toggle("show");
    }

    /**
     * Ferme le menu déroulant si l'utilisateur clique en dehors de celui-ci.
     */
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>

<style>
    /* Taken from: https://www.w3schools.com/howto/howto_js_dropdown.asp */

    /* Dropdown Button */
    .dropbtn {
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        right: 0;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #ddd;
    }

    /* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
    .show {
        display: block;
    }
</style>