<?php

namespace App\model;

class DB{
    private ?\PDO $connexion = null;


    public static function getConnexion(){
        if(self::$connexion === null){

        
        self ::$connexion = new \PDO('mysql:host=localhost;dbname=lib;charset=utf8mb4','root','O2H2sql');
        return self::$connexion;
        }else{
            return self::$connexion;
        }
    }
}