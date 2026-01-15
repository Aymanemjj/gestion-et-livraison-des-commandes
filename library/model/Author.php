<?php

namespace App\model;

class Author extends Person{



    public function setters( string $firstname, string $lastname)
    {
        $this->setFirstname($firstname)->setLastname($lastname);
    }
}