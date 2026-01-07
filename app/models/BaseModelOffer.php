<?php

namespace App\models;

class BaseModelOffer
{




    public function __construct() {}

    public function save($price, $delivery_type, $vehicule, $command_id, $user_id)
    {
        $sql = "INSERT INTO offers (price, delivery_type, vehicule, command_id, user_id) VALUES (:price, :delivery_type, :vehicule, :command_id, :user_id)";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':price', $price, \PDO::PARAM_INT);
        $stmt->bindParam(':delivery_type', $delivery_type, \PDO::PARAM_STR);
        $stmt->bindParam(':vehicule', $vehicule, \PDO::PARAM_INT);
        $stmt->bindParam(':command_id', $command_id, \PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        

        $stmt->execute();
    }

    public function find($price)
    {
        $sql = "SELECT * FROM offers WHERE price < :price";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':price', $price, \PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, Offer::class);
        return $stmt->fetchAll();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM offers WHERE id = :id";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
}
