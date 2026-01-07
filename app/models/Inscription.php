<?php

namespace App\models;

class Inscription{

    private ?string $firstname;

    private ?string $lastname;

    private string $email;

    private string $password;

    private int $role;

    public function __construct($email, $password, ?string $firstname, ?string $lastname, ?int $role)
    {

        $this->email = $email;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->role = $role;
    }

    public function SignUp(){
        
    }


}