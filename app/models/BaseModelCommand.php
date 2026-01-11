<?php

namespace App\models;

class BaseModelCommand
{




    public function __construct() {}


    protected function validate()
    {
        $pattern = "/^[A-Za-z0-9._-]*/$";
        return
            preg_match($pattern, $this->getTitle()) === 1 &&
            preg_match($pattern, $this->getDetails()) === 1 &&
            preg_match($pattern, $this->getAddress()) === 1;;
    }

    public function save()
    {
        $sql = "INSERT INTO commands (title, details, user_id, address) VALUES (:title, :details, :user_id, :address)";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':title', $this->getTitle(), \PDO::PARAM_STR);
        $stmt->bindParam(':details', $this->getDetails(), \PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $this->getUser_id(), \PDO::PARAM_INT);
        $stmt->bindParam(':address', $this->getAddress(), \PDO::PARAM_INT);


        $stmt->execute();
    }

    public function find()
    {
        $sql = "SELECT * FROM commands WHERE user_id = :user_id";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':user_id', $_SESSION['user_id'], \PDO::PARAM_STR);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Command::class);

        return $stmt->fetchAll();
    }

    public function delete()
    {
        $sql = "DELETE FROM commands WHERE title = :title";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':title', $this->title, \PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
}
