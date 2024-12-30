<?php
include_once('../includes/db.php');

include_once('../models/user.php');
include_once('../controllers/users.php');

$usersController = new UsersController($db);
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($username == '' || $email == '' || $password == '') {
        $errorMessage = "Le formulaire n'est pas correct";
    } else {
        $user = $usersController->getByUsername($username);

        if ($user != NULL) {
            $errorMessage = "Le nom d'utilisateur existe déjà";
        } else {
            $user = new User(0, $username, $email, $password);
            $usersController->save($user);
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

    <title>AjiBook - Créer un compte</title>
</head>


<body>
    <div class="main-container">
        <?php include('../includes/header.php'); ?>

        <main class="main">
            <section>
                <h1 class="title">Inscription</h1>
                <form action="../pages/signup.php" method="POST" class="signup-form">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" name="username" class="input-field" />

                    <label for="email">Email</label>
                    <input type="email" name="email" class="input-field" />

                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" class="input-field" />

                    <? if ($errorMessage != ''): ?>
                        <p class="error-message"><?= $errorMessage ?></p>
                    <? endif ?>

                    <button class="login-button-inscription">Créer</button>
                </form>
            </section>
        </main>

        <?php include('../includes/footer.php'); ?>
    </div>
</body>

</html>

<style>
    .main {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        margin-top: 50px;
    }

    .title {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    .signup-form {
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

    .signup-form label {
        font-size: 14px;
        color: #555;
    }

    .input-field {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        transition: border-color 0.3s ease;
    }

    .error-message {
        color: #e63946;
        font-weight: bold;
        font-size: 14px;
        margin-top: 5px;
    }

    .login-button-inscription {
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