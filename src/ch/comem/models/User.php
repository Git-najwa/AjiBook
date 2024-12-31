<?php

namespace ch\comem\models;

class User
{

    // Propriétés privées de la classe
    private $id;
    private $username;
    private $email;
    private $password;

    /**
     * Constructeur de la classe User.
     * Initialise les propriétés avec les valeurs fournies.
     *
     * @param int $id L'identifiant unique de l'utilisateur
     * @param string $username Le nom d'utilisateur
     * @param string $email L'adresse e-mail de l'utilisateur
     * @param string $password Le mot de passe de l'utilisateur (doit être sécurisé)
     */
    public function __construct($id, $username, $email, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Retourne l'identifiant de l'utilisateur.
     *
     * @return int L'identifiant unique de l'utilisateur
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retourne le nom d'utilisateur.
     *
     * @return string Le nom d'utilisateur
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Retourne l'adresse e-mail de l'utilisateur.
     *
     * @return string L'adresse e-mail de l'utilisateur
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Retourne le mot de passe de l'utilisateur.
     * Remarque : le mot de passe doit être manipulé avec précaution.
     *
     * @return string Le mot de passe (probablement haché)
     */
    public function getPassword()
    {
        return $this->password;
    }
}
