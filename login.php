<?php

require_once('./config/autoload.php');

use ch\comem\DB;
use ch\comem\controllers\UsersController;

$db = new DB();

// Création d'une instance du contrôleur des utilisateurs
$usersController = new UsersController($db);
// Variable pour stocker le message d'erreur en cas de problème
$errorMessage = '';

// Vérification de la méthode HTTP pour traiter les données du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification si les champs sont vides
    if ($username == '' || $password == '') {
        $errorMessage = "Le formulaire n'est pas correct";
    } else {
        // Recherche de l'utilisateur par son nom d'utilisateur
        $user = $usersController->getByUsername($username);

        // Vérification du mot de passe et de l'existence de l'utilisateur
        if ($user && password_verify($password, $user->getPassword())) {
            // Démarrage de la session et stockage de l'utilisateur dans la session
            session_start();
            $_SESSION['user'] = $user;

            // Redirection vers la page d'accueil après une connexion réussie
            header('Location: ./');
        } else {
            // Message d'erreur si l'utilisateur n'existe pas ou le mot de passe est incorrect
            $errorMessage = "Erreur de connexion";
        }
    }
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

    <title>AjiBook - Se connecter</title>
</head>


<body>
    <div class="main-container">
        <!-- Inclusion de l'en-tête de la page -->
        <?php include('./includes/header.php'); ?>

        <main class="main">
            <section>
                <h1 class="title">Connexion</h1>
                <!-- Formulaire de connexion avec méthode POST -->
                <form action="./login.php" method="POST" class="login-form">

                    <!-- Champ pour le nom d'utilisateur -->
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" name="username" class="input-field" />

                    <!-- Champ pour le mot de passe -->
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" class="input-field" />

                    <!-- Affichage du message d'erreur si présent -->
                    <? if ($errorMessage != ''): ?>
                        <p class="error-message"><?= $errorMessage ?></p>
                    <? endif ?>

                    <!-- Lien vers la page d'inscription si l'utilisateur n'a pas encore de compte -->
                    <div>
                        <p class="signup-prompt">
                            Pas encore de compte ? <a href="./signup.php" class="signup-link">S'inscrire</a>
                        </p>
                    </div>

                    <!-- Bouton pour soumettre le formulaire de connexion -->
                    <button class="login-button-connexion">Se connecter</button>
                </form>
            </section>
        </main>

        <!-- Inclusion du pied de page -->
        <?php include('./includes/footer.php'); ?>
    </div>
</body>

</html>

<style>
    /* Style principal pour l'alignement de la page */
    .main {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        margin-top: 50px;
    }

    /* Style du titre principal */
    .title {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    /* Style du formulaire de connexion */
    .login-form {
        display: flex;
        flex-direction: column;
        gap: 12px;
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    /* Style des labels des champs de formulaire */
    .login-form label {
        font-size: 14px;
        color: #555;
    }

    /* Style des champs de saisie */
    .input-field {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        transition: border-color 0.3s ease;
    }

    /* Style du message d'erreur */
    .error-message {
        color: #e63946;
        font-weight: bold;
        font-size: 14px;
        margin-top: 5px;
    }

    /* Style du texte pour l'invite d'inscription */
    .signup-prompt {
        font-size: 12px;
        /* Texte plus petit */
        text-align: center;
        color: #555;
        margin-bottom: 10px;
    }

    /* Style du lien pour l'inscription */
    .signup-link {
        color: #4D433A;
        text-decoration: none;
        font-weight: bold;
    }

    /* Effet de survol du lien d'inscription */
    .signup-link:hover {
        text-decoration: underline;
    }

    /* Style du bouton de connexion */
    .login-button-connexion {
        background-color: #EBB231;
        color: white;
        padding: 12px;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
</style>