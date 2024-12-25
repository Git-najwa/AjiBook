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
}
