<?php

namespace App\model;

class Membre extends User{



    public function setters( string $firstname, string $lastname, string $email, string $password )
    {
        $this->setFirstname($firstname)->setLastname($lastname)->setEmail($email)->setPassword($password);
    }

    public function reserve(){

    }
    public function return(){

    }
    public function unSub(){

    }
}