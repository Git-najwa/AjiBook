<?php

include_once("../models/recipe.php");

class RecipesController
{

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $result = $this->db->query('SELECT * FROM recipes')->fetchAll();

        return array_map(function ($result) {
            return new Recipe(
                $result['id'],
                $result['title'],
                $result['ingredients'],
                $result['instructions'],
                $result['category'],
                $result['createdAt'],
                $result['userId']
            );
        }, $result);
    }

    public function getByCategory($category): array
    {
        $statement = $this->db->prepare("SELECT * FROM recipes WHERE category = :category");
        $statement->execute(['category' => $category]);
        $result = $statement->fetchAll();

        return array_map(function ($result) {
            return new Recipe(
                $result['id'],
                $result['title'],
                $result['ingredients'],
                $result['instructions'],
                $result['category'],
                $result['createdAt'],
                $result['userId']
            );
        }, $result);
    }

    public function getByUsersId($usersId): array
    {
        $statement = $this->db->prepare("SELECT * FROM recipes WHERE users_id = :users_id");
        $statement->execute(['users_id' => $usersId]);
        $result = $statement->fetchAll();

        return array_map(function ($result) {
            return new Recipe(
                $result['id'],
                $result['title'],
                $result['ingredients'],
                $result['instructions'],
                $result['category'],
                $result['createdAt'],
                $result['userId']
            );
        }, $result);
    }

    public function getById($id): ?Recipe
    {
        $statement = $this->db->prepare("SELECT * FROM recipes WHERE id = :id");
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();

        if (!$result) {
            return null;
        }

        return new Recipe(
            $result['id'],
            $result['title'],
            $result['ingredients'],
            $result['instructions'],
            $result['category'],
            $result['createdAt'],
            $result['userId']
        );
    }

    public function save(Recipe $recipe)
    {
        $statement = $this->db->prepare('INSERT INTO recipes (title, ingredients, instructions, category, users_id) VALUES (:title, :ingredients, :instructions, :category, :users_id)');
        $statement->execute([
            'title' => $recipe->getTitle(),
            'ingredients' => $recipe->getIngredients(),
            'instructions' => $recipe->getInstructions(),
            'category' => $recipe->getCategory(),
            'users_id' => $recipe->getUsersId(),
        ]);
    }
}
