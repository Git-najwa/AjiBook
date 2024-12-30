<?php

// Inclusion du modèle d'utilisateur, si nécessaire pour des interactions futures avec la base de données
include_once('../models/user.php');

// Démarrage de la session
session_start();
// Détruire la session actuelle
session_destroy();

// Redirection vers la page principale après la déconnexion
header('Location: ../pages');
