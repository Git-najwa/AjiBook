<?php

class UsersController
{
    private PDO $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getByUsername($username): ?User
    {
        $statement = $this->db->prepare('SELECT * FROM users WHERE username = :username');
        $statement->execute(['username' => $username]);
        $result = $statement->fetch();

        if (!$result) {
            return null;
        }

        return new User(
            $result['id'],
            $result['username'],
            $result['email'],
            $result['password']
        );
    }

    public function getById($id): ?User
    {
        $statement = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();

        if (!$result) {
            return null;
        }

        return new User(
            $result['id'],
            $result['username'],
            $result['email'],
            $result['password']
        );
    }

    public function save(User $user)
    {
        $statement = $this->db->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
        $statement->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT)
        ]);
    }
}
