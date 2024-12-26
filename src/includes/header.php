<?php
include_once('../models/user.php');

$requestUrl = $_SERVER['REQUEST_URI'];

session_start();
$userSession = $_SESSION['user'];

?>

<!-- Barre supérieure -->
<div class="top-bar">
    <a class="logo" href="../pages">
        <img src=" ../assets/img/logo.png" alt="Logo" />
    </a>
    <div class="search-bar">
        <input type="text" placeholder="Recherche..." />
        <button>
            <img src="../assets/img/search-icon.png" alt="Rechercher" />
        </button>
    </div>
    <? if ($userSession == null): ?>
        <div class="login-button">
            <a href="../pages/login.php">Connexion</a>
        </div>
    <? else: ?>
        <div class="dropdown">
            <button onclick="openDropdown()" class="dropbtn"><?= $userSession->getUsername() ?></button>
            <div id="dropdown" class="dropdown-content">
                <a href="#">Mon profil</a>
                <a href="../pages/my-recipes.php">Mes recettes</a>
                <a href="../pages/my-bookmarks.php">Mes favoris</a>
                <a href="../pages/logout.php">Déconnexion</a>
            </div>
        </div>
    <? endif ?>
</div>

<!-- Barre de menu -->
<nav class="menu">
    <ul>
        <li>
            <a href="../pages/aperitifs.php" class="<?= str_ends_with($requestUrl, "aperitifs.php") ? 'selected-item' : '' ?>">Apéritifs</a>
        </li>
        <li>
            <a href="../pages/entrees.php" class="<?= str_ends_with($requestUrl, "entrees.php") ? 'selected-item' : '' ?>">Entrées</a>
        </li>
        <li>
            <a href="../pages/plats.php" class="<?= str_ends_with($requestUrl, "plats.php") ? 'selected-item' : '' ?>">Plats</a>
        </li>
        <li>
            <a href="../pages/desserts.php" class="<?= str_ends_with($requestUrl, "desserts.php") ? 'selected-item' : '' ?>">Desserts</a>
        </li>
        <li>
            <a href="../pages/boissons.php" class="<?= str_ends_with($requestUrl, "boissons.php") ? 'selected-item' : '' ?>">Boissons</a>
        </li>
    </ul>
</nav>

<script>
    /* When the user clicks on the button, toggle between hiding and showing the dropdown content */
    function openDropdown() {
        document.getElementById("dropdown").classList.toggle("show");
    }

    // Close the dropdown menu if the user clicks outside of it
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