<?php

require_once('./config/autoload.php');

// Démarrage de la session
session_start();
// Détruire la session actuelle
session_destroy();

// Redirection vers la page principale après la déconnexion
header('Location: ./');
