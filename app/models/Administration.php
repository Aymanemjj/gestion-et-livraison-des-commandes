<?php

namespace App\models;

class Administration
{
    public function countTotalCommands()
    {
        $sql = "SELECT COUNT(*) AS total FROM commands";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_COLUMN);
    }
    public function countPendingCommands()
    {
        $sql = "SELECT COUNT(*) AS pending FROM commands WHERE status = 'pending'";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_COLUMN);
    }

    public function countActiveDrivers()
    {
        $sql = "SELECT COUNT(*) AS total FROM users WHERE role = 3 AND status = 1";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_COLUMN);
    }
}
