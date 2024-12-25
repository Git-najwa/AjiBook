<?php

include_once("../models/recipe.php");

class RecipesController {

    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAll(): array {
        $recipes = $this->db->query('SELECT * FROM recipes')->fetchAll();

        return $recipes;
    }
}