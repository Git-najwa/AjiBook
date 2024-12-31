<?php

// Inclusion du modèle Recipe pour pouvoir l'utiliser dans ce contrôleur
include_once("../models/recipe.php");

class RecipesController
{
    // Propriété pour la connexion à la base de données
    private PDO $db;

    // Constructeur qui initialise la connexion à la base de données
    public function __construct(PDO $db)
    {
        $this->db = $db; // On assigne l'objet PDO à la propriété $db
    }

    /**
     * Méthode pour récupérer toutes les recettes
     * 
     * @return array Un tableau d'objets Recipe
     */
    public function getAll(): array
    {
        // Récupération de toutes les recettes depuis la base de données
        $result = $this->db->query('SELECT * FROM recipes')->fetchAll();

        // Transformation des résultats en objets Recipe
        return array_map(function ($result) {
            return new Recipe(
                $result['id'],
                $result['title'],
                $result['ingredients'],
                $result['instructions'],
                $result['category'],
                $result['created_at'],
                $result['image_url'],
                $result['users_id']
            );
        }, $result);
    }

    /**
     * Méthode pour récupérer les recettes d'une catégorie spécifique
     * 
     * @param string $category La catégorie de recettes
     * @return array Un tableau d'objets Recipe
     */
    public function getByCategory($category): array
    {
        // Préparation de la requête SQL pour récupérer les recettes par catégorie
        $statement = $this->db->prepare("SELECT * FROM recipes WHERE category = :category");
        // Exécution de la requête avec la catégorie comme paramètre
        $statement->execute(['category' => $category]);
        $result = $statement->fetchAll();

        // Transformation des résultats en objets Recipe
        return array_map(function ($result) {
            return new Recipe(
                $result['id'],
                $result['title'],
                $result['ingredients'],
                $result['instructions'],
                $result['category'],
                $result['created_at'],
                $result['image_url'],
                $result['users_id']
            );
        }, $result);
    }

    /**
     * Méthode pour récupérer toutes les recettes d'un utilisateur par son ID
     * 
     * @param int $usersId L'ID de l'utilisateur
     * @return array Un tableau d'objets Recipe
     */
    public function getByUsersId($usersId): array
    {
        // Préparation de la requête SQL pour récupérer les recettes par ID utilisateur
        $statement = $this->db->prepare("SELECT * FROM recipes WHERE users_id = :users_id");
        // Exécution de la requête avec l'ID de l'utilisateur comme paramètre
        $statement->execute(['users_id' => $usersId]);
        $result = $statement->fetchAll();

        // Transformation des résultats en objets Recipe
        return array_map(function ($result) {
            return new Recipe(
                $result['id'],
                $result['title'],
                $result['ingredients'],
                $result['instructions'],
                $result['category'],
                $result['created_at'],
                $result['image_url'],
                $result['users_id']
            );
        }, $result);
    }

    /**
     * Méthode pour récupérer une recette par son ID
     * 
     * @param int $id L'ID de la recette
     * @return Recipe|null Un objet Recipe ou null si aucune recette n'est trouvée
     */
    public function getById($id): ?Recipe
    {
        // Préparation de la requête SQL pour récupérer une recette par son ID
        $statement = $this->db->prepare("SELECT * FROM recipes WHERE id = :id");
        // Exécution de la requête avec l'ID de la recette comme paramètre
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();

        // Si aucune recette n'est trouvée, on retourne null
        if (!$result) {
            return null;
        }

        // Transformation du résultat en un objet Recipe
        return new Recipe(
            $result['id'],
            $result['title'],
            $result['ingredients'],
            $result['instructions'],
            $result['category'],
            $result['created_at'],
            $result['image_url'],
            $result['users_id']
        );
    }

    /**
     * Méthode pour récupérer les recettes sauvegardées par un utilisateur (bookmarks)
     * 
     * @param int $usersId L'ID de l'utilisateur
     * @return array Un tableau d'objets Recipe correspondant aux recettes bookmarkées
     */
    public function getBookmarkedRecipes($usersId)
    {
        // Préparation de la requête SQL pour récupérer les recettes bookmarkées d'un utilisateur
        $statement = $this->db->prepare("SELECT * FROM bookmarks INNER JOIN recipes ON bookmarks.recipes_id = recipes.id WHERE bookmarks.users_id = :users_id");
        // Exécution de la requête avec l'ID de l'utilisateur comme paramètre
        $statement->execute(['users_id' => $usersId]);
        $result = $statement->fetchAll();

        // Transformation des résultats en objets Recipe
        return array_map(function ($result) {
            return new Recipe(
                $result['id'],
                $result['title'],
                $result['ingredients'],
                $result['instructions'],
                $result['category'],
                $result['created_at'],
                $result['image_url'],
                $result['users_id']
            );
        }, $result);
    }

    /**
     * Méthode pour récupérer les dernières recettes ajoutées, limitées à 20
     * 
     * @return array Un tableau d'objets Recipe correspondant aux dernières recettes
     */
    public function getLatestRecipes()
    {
        // Récupération des 20 dernières recettes ajoutées, triées par date de création
        $result = $this->db->query('SELECT * FROM recipes ORDER BY created_at DESC LIMIT 20')->fetchAll();
        // Transformation des résultats en objets Recipe
        return array_map(function ($result) {
            return new Recipe(
                $result['id'],
                $result['title'],
                $result['ingredients'],
                $result['instructions'],
                $result['category'],
                $result['created_at'],
                $result['image_url'],
                $result['users_id']
            );
        }, $result);
    }

    /**
     * Méthode pour enregistrer une nouvelle recette dans la base de données
     * 
     * @param Recipe $recipe Un objet Recipe à enregistrer
     * @return int L'ID de la recette nouvellement insérée
     */
    public function save(Recipe $recipe): int
    {
        // Préparation de la requête SQL pour insérer une nouvelle recette
        $statement = $this->db->prepare('INSERT INTO recipes (title, ingredients, instructions, category, image_url, users_id) VALUES (:title, :ingredients, :instructions, :category, :image_url, :users_id)');
        // Exécution de la requête en passant les données de la recette
        $statement->execute([
            'title' => $recipe->getTitle(),
            'ingredients' => $recipe->getIngredients(),
            'instructions' => $recipe->getInstructions(),
            'category' => $recipe->getCategory(),
            'image_url' => $recipe->getImageUrl(),
            'users_id' => $recipe->getUsersId(),
        ]);

        // Retourne l'ID de la recette nouvellement insérée
        return $this->db->lastInsertId();
    }


    /**
     * Méthode pour supprimer une recette
     * 
     * @param int $id L'identifiant de la recette à supprimer
     */
    public function delete($id)
    {
        // Exécution de la requête SQL pour supprimer la recette
        $this->db->query('DELETE FROM recipes WHERE id = :id')->execute(['id' => $id]);
    }
}
