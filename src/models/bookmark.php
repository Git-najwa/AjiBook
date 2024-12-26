<?php

class Bookmark
{

    private $id;
    private $createdAt;
    private $recipesId;
    private $usersId;

    public function __construct($id, $createdAt, $recipesId, $usersId)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->recipesId = $recipesId;
        $this->usersId = $usersId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getRecipesId()
    {
        return $this->recipesId;
    }

    public function getUsersId()
    {
        return $this->usersId;
    }
}
