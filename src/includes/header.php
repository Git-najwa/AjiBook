<?php
$requestUrl = $_SERVER['REQUEST_URI'];
?>

<!-- Barre supérieure -->
<div class="top-bar">
    <div class="logo">
        <img src="../assets/img/logo.png" alt="Logo" />
    </div>
    <div class="search-bar">
        <input type="text" placeholder="Recherche..." />
        <button>
            <img src="../assets/img/search-icon.png" alt="Rechercher" />
        </button>
    </div>
    <div class="login-button">
        <button>Connexion</button>
    </div>
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