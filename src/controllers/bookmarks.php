<?php

include_once("../models/bookmark.php");

class BookmarksController
{

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getByUsersId($usersId): array
    {
        $statement = $this->db->prepare("SELECT * FROM bookmarks WHERE users_id = :users_id");
        $statement->execute(['users_id' => $usersId]);
        $result = $statement->fetchAll();

        return array_map(function ($result) {
            return new Bookmark(
                $result['id'],
                $result['created_at'],
                $result['recipes_id'],
                $result['users_id'],
            );
        }, $result);
    }

    public function save(Bookmark $bookmark)
    {
        $statement = $this->db->prepare('INSERT INTO bookmarks (recipes_id, users_id) VALUES (:recipes_id, :users_id)');
        $statement->execute([
            'recipes_id' => $bookmark->getRecipesId(),
            'users_id' => $bookmark->getUsersId(),
        ]);
    }

    public function delete($usersId, $recipesId)
    {
        $statement = $this->db->prepare('DELETE FROM bookmarks WHERE recipes_id = :recipes_id AND users_id = :users_id');
        $statement->execute([
            'recipes_id' => $recipesId,
            'users_id' => $usersId,
        ]);
    }
}
