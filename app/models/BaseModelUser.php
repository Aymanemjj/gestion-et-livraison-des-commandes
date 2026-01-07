<?php

namespace App\models;

class BaseModelUser
{




    public function __construct() {}

    public function save($firstname, $lastname, $email, $password, $role)
    {
        $sql = "INSERT INTO users (firstname, lastname, email, password, role) VALUES (:firstname, :lastname, :email, :password, :role)";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':firstname', $firstname, \PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, \PDO::PARAM_INT);

        $stmt->execute();
    }

    public function find($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class);
        return $stmt->fetchAll();


        /*         $stmt->setFetchMode(\PDO::FETCH_OBJ,User::class);
 */
        /*         return$stmt->fetchObject('User');
 */
    }

    public function delete($email)
    {
        $sql = "DELETE FROM users WHERE email = :email";
        $connexion = Database::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
}
