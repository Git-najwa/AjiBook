<?php
include_once('../includes/db.php');

include_once('../models/user.php');
include_once('../controllers/users.php');

$usersController = new UsersController($db);
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == '' || $password == '') {
        $errorMessage = "Le formulaire n'est pas correct";
    } else {
        $user = $usersController->getByUsername($username);

        if ($user && password_verify($password, $user->getPassword())) {
            session_start();
            $_SESSION['user'] = $user;

            header('Location: ../pages/');
        } else {
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

    <link rel="stylesheet" href="../assets/styles.css" />

    <title>AjiBook - Se connecter</title>
</head>


<body>
    <div class="main-container">
        <?php include('../includes/header.php'); ?>

        <main class="main">
            <form action="../pages/login.php" method="POST" class="login-form">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" />

                <label for="password">Mot de passe</label>
                <input type="password" name="password" />

                <? if ($errorMessage != ''): ?>
                    <p class="error-message"><?= $errorMessage ?></p>
                <? endif ?>

                <button>Se connecter</button>
            </form>

        </main>

        <?php include('../includes/footer.php'); ?>
    </div>
</body>

</html>

<style>
    .main {
        display: flex;
        justify-content: center;
        align-items: start;
        margin: 24px 0;
    }

    .login-form {
        display: flex;
        flex-direction: column;
        gap: 6px;
        background-color: #fff;
        border: 1px solid #ccc;
        padding: 12px 24px;
    }

    .error-message {
        color: #c42312;
        font-weight: bold;
    }
</style>