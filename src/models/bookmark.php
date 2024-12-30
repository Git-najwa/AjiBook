<?php

class Bookmark
{

    // Propriétés privées de la classe
    private $id;
    private $createdAt;
    private $recipesId;
    private $usersId;

    /**
     * Constructeur de la classe Bookmark.
     * Initialise les propriétés avec les valeurs passées en paramètres.
     *
     * @param int $id L'identifiant unique du favori
     * @param string $createdAt La date de création du favori
     * @param int $recipesId L'identifiant de la recette associée
     * @param int $usersId L'identifiant de l'utilisateur ayant ajouté le favori
     */
    public function __construct($id, $createdAt, $recipesId, $usersId)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->recipesId = $recipesId;
        $this->usersId = $usersId;
    }

    /**
     * Retourne l'identifiant du favori.
     *
     * @return int L'identifiant du favori
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retourne la date de création du favori.
     *
     * @return string La date de création du favori
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }


    /**
     * Retourne l'identifiant de la recette associée au favori.
     *
     * @return int L'identifiant de la recette
     */
    public function getRecipesId()
    {
        return $this->recipesId;
    }

    /**
     * Retourne l'identifiant de l'utilisateur ayant ajouté le favori.
     *
     * @return int L'identifiant de l'utilisateur
     */
    public function getUsersId()
    {
        return $this->usersId;
    }
}
