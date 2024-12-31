<?php

namespace ch\comem\controllers;

use PDO;
use ch\comem\DB;
use ch\comem\models\User;

// Contrôleur pour la gestion des utilisateurs
class UsersController
{
    // Propriété pour stocker la connexion à la base de données
    private PDO $db;

    /**
     * Constructeur pour initialiser la connexion à la base de données.
     */
    public function __construct(DB $db)
    {
        $this->db = $db->getDB();
    }

    /**
     * Méthode pour récupérer un utilisateur par son nom d'utilisateur (username).
     *
     * @param string $username Le nom d'utilisateur à rechercher.
     * @return User|null Un objet User si trouvé, sinon null.
     */
    public function getByUsername($username): ?User
    {
        // Préparation de la requête pour récupérer l'utilisateur par son nom d'utilisateur
        $statement = $this->db->prepare('SELECT * FROM users WHERE username = :username');
        // Exécution de la requête avec le paramètre :username
        $statement->execute(['username' => $username]);
        $result = $statement->fetch();

        // Si aucun utilisateur n'est trouvé, on retourne null
        if (!$result) {
            return null;
        }

        // Création et retour d'un objet User à partir des données récupérées
        return new User(
            $result['id'],
            $result['username'],
            $result['email'],
            $result['password']
        );
    }

    /**
     * Méthode pour récupérer un utilisateur par son ID.
     *
     * @param int $id L'ID de l'utilisateur à rechercher.
     * @return User|null Un objet User si trouvé, sinon null.
     */
    public function getById($id): ?User
    {
        // Préparation de la requête pour récupérer l'utilisateur par son ID
        $statement = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        // Exécution de la requête avec le paramètre :id
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();

        // Si aucun utilisateur n'est trouvé, on retourne null
        if (!$result) {
            return null;
        }

        // Création et retour d'un objet User à partir des données récupérées
        return new User(
            $result['id'],
            $result['username'],
            $result['email'],
            $result['password']
        );
    }

    /**
     * Méthode pour sauvegarder un nouvel utilisateur dans la base de données.
     *
     * @param User $user Un objet User contenant les informations de l'utilisateur à sauvegarder.
     */
    public function save(User $user)
    {
        // Préparation de la requête pour insérer un nouvel utilisateur
        $statement = $this->db->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
        // Exécution de la requête avec les données de l'objet User
        $statement->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            // Le mot de passe est haché avant d'être inséré dans la base de données pour des raisons de sécurité
            'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT)
        ]);
    }
}
