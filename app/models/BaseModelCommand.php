<?php

namespace App\models;

class BaseModelCommand
{




    public function __construct() {}

    protected function save()
    {
        $sql = "INSERT INTO commands (title, details, user_id) VALUES (:title, :details, :user_id)";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':title', $this->title, \PDO::PARAM_STR);
        $stmt->bindParam(':details', $this->details, \PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $this->user_id, \PDO::PARAM_INT);

        $stmt->execute();
    }

    protected function find()
    {
        $sql = "SELECT * FROM commands WHERE title = :title";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':title', $this->title, \PDO::PARAM_STR);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Command::class);
        return $stmt->fetchAll();
    }

    protected function delete()
    {
        $sql = "DELETE FROM commands WHERE title = :title";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':title', $this->title, \PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
}
