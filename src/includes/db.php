<?php

// Chargement des configurations depuis un fichier INI
$config = parse_ini_file('../../config.ini', true);
// La fonction parse_ini_file lit un fichier INI et retourne un tableau associatif.
// Le deuxième paramètre (true) permet de gérer des sections dans le fichier INI.

$dsn = $config['dsn'];
// On récupère la chaîne de connexion DSN (Data Source Name) à partir des configurations.
// Cette chaîne est utilisée pour se connecter à la base de données.

$db = new \PDO($dsn, $username, $password);
// L'objet PDO représente une connexion à la base de données.
// $dsn fournit les informations sur le type de base de données, l'hôte, le nom de la base, etc.
// $username et $password sont utilisés pour l'authentification.