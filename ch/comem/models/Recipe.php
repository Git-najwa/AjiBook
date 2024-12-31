<?php

namespace ch\comem\models;

class Recipe
{

    // Propriétés privées de la classe
    private $id;
    private $title;
    private $ingredients;
    private $instructions;
    private $category;
    private $createdAt;
    private $imageUrl;
    private $usersId;

    // Traductions des catégories pour un affichage utilisateur
    private static $categoryTranslations = array(
        "appetizer" => "Apéritif",
        "starter" => "Entrée",
        "main-course" => "Plat principal",
        "drink" => "Boisson",
        "desert" => "Dessert"
    );

    /**
     * Constructeur de la classe Recipe.
     * Initialise les propriétés avec les valeurs passées en paramètres.
     *
     * @param int $id L'identifiant unique de la recette
     * @param string $title Le titre de la recette
     * @param string $ingredients La liste des ingrédients
     * @param string $instructions Les instructions pour préparer la recette
     * @param string $category La catégorie de la recette
     * @param string $createdAt La date de création de la recette
     * @param string $imageUrl L'URL de l'image associée à la recette
     * @param int $usersId L'identifiant de l'utilisateur qui a créé la recette
     */
    public function __construct($id, $title, $ingredients, $instructions, $category, $createdAt, $imageUrl, $usersId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->ingredients = $ingredients;
        $this->instructions = $instructions;
        $this->category = $category;
        $this->createdAt = $createdAt;
        $this->imageUrl = $imageUrl;
        $this->usersId = $usersId;
    }

    /**
     * Retourne l'identifiant de la recette.
     *
     * @return int L'identifiant de la recette
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retourne le titre de la recette.
     *
     * @return string Le titre de la recette
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Retourne les ingrédients de la recette.
     *
     * @return string Les ingrédients de la recette
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Retourne les instructions pour préparer la recette.
     *
     * @return string Les instructions de la recette
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Retourne la catégorie de la recette.
     *
     * @return string La catégorie de la recette
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Retourne la traduction de la catégorie de la recette.
     *
     * @return string La catégorie traduite en français
     */
    public function getTranslatedCategory()
    {
        return Recipe::$categoryTranslations[$this->category];
    }

    /**
     * Retourne la date de création de la recette.
     *
     * @return string La date de création
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Retourne l'URL de l'image associée à la recette.
     *
     * @return string L'URL de l'image
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Retourne l'identifiant de l'utilisateur qui a créé la recette.
     *
     * @return int L'identifiant de l'utilisateur
     */
    public function getUsersId()
    {
        return $this->usersId;
    }
}
