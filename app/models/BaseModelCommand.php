<?php

namespace App\models;

class BaseModelCommand
{




    public function __construct() {}

    public function save($title, $details, $user_id)
    {
        $sql = "INSERT INTO commands (title, details, user_id) VALUES (:title, :details, :user_id)";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, \PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);

        $stmt->execute();
    }

    public function find($title)
    {
        $sql = "SELECT * FROM commands WHERE title = :title";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Command::class);
        return $stmt->fetchAll();
    }

    public function delete($title)
    {
        $sql = "DELETE FROM commands WHERE title = :title";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
}
