<?php

namespace ch\comem\controllers;

use PDO;
use ch\comem\DB;
use ch\comem\models\Bookmark;

class BookmarksController
{
    // Propriété pour la connexion à la base de données
    private PDO $db;

    // Constructeur qui initialise la connexion à la base de données
    public function __construct(DB $db)
    {
        $this->db = $db->getDB();
    }

    /**
     * Méthode pour obtenir tous les bookmarks d'un utilisateur à partir de son ID
     * 
     * @param int $usersId L'ID de l'utilisateur
     * @return array Un tableau d'objets Bookmark
     */
    public function getByUsersId($usersId): array
    {
        // Préparation de la requête SQL pour récupérer les bookmarks d'un utilisateur spécifique
        $statement = $this->db->prepare("SELECT * FROM bookmarks WHERE users_id = :users_id");
        // Exécution de la requête avec l'ID de l'utilisateur comme paramètre
        $statement->execute(['users_id' => $usersId]);
        // Récupération de tous les résultats de la requête
        $result = $statement->fetchAll();

        // Transformation des résultats en objets Bookmark
        return array_map(function ($result) {
            return new Bookmark(
                $result['id'],
                $result['created_at'],
                $result['recipes_id'],
                $result['users_id'],
            );
        }, $result);
    }

    /**
     * Méthode pour enregistrer un nouveau bookmark dans la base de données
     * 
     * @param Bookmark $bookmark Un objet Bookmark à enregistrer
     */
    public function save(Bookmark $bookmark)
    {
        $statement = $this->db->prepare('INSERT INTO bookmarks (recipes_id, users_id) VALUES (:recipes_id, :users_id)');
        $statement->execute([
            'recipes_id' => $bookmark->getRecipesId(),
            'users_id' => $bookmark->getUsersId(),
        ]);
    }

    /**
     * Méthode pour supprimer un bookmark de la base de données
     * 
     * @param int $usersId L'ID de l'utilisateur
     * @param int $recipesId L'ID de la recette
     */
    public function delete($usersId, $recipesId)
    {
        $statement = $this->db->prepare('DELETE FROM bookmarks WHERE recipes_id = :recipes_id AND users_id = :users_id');
        $statement->execute([
            'recipes_id' => $recipesId,
            'users_id' => $usersId,
        ]);
    }
}
