<?php

namespace App\models;
use \PDO;

class Database
{
    protected static ?PDO $connexion = null;
    private function __construct(){}

    public static function getConnexion()
    {
        if (self::$connexion === null) {
            self::$connexion = new PDO('mysql:host=localhost;dbname=shipping;charset=utf8mb4','root','O2H2sql',);
        }
        return self::$connexion;
    }
}

