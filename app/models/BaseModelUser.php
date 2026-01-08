<?php

namespace App\models;

class BaseModelUser
{




    public function __construct() {}

    public function save()
    {
        $sql = "INSERT INTO users (firstname, lastname, email, password, role) VALUES (:firstname, :lastname, :email, :password, :role)";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue(':firstname', $this->getFirstname(), \PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $this->getLastname(), \PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(':password', $this->getPassword(), \PDO::PARAM_STR);
        $stmt->bindValue(':role', $this->getRole(), \PDO::PARAM_INT);

        $stmt->execute();
    }

    public function find()
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue(':email', $this->getEmail(), \PDO::PARAM_STR);
        $stmt->execute();
        

/*         $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class);*/
        return $stmt->fetchObject();
        
     }

    public function delete()
    {
        $sql = "DELETE FROM users WHERE email = :email";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue(':email', $this->getEmail(), \PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
}
