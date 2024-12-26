<?php

include_once("../models/bookmark.php");

class BookmarksController
{

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Bookmark $bookmark)
    {
        $statement = $this->db->prepare('INSERT INTO bookmarks (recipes_id, users_id) VALUES (:recipes_id, :users_id)');
        $statement->execute([
            'recipes_id' => $bookmark->getRecipesId(),
            'users_id' => $bookmark->getUsersId(),
        ]);
    }
}
