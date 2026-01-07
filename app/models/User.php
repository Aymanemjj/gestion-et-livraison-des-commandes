<?php
namespace App\models;

class User{
    private string $firstname;

    private string $lastname;

    private string $email;

    private string $password;

    private int $role;

    private bool $status;

/*     public function __construct($firstname, $lastname, $emfindail, $password, $role, $status)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->status = $status;
    }
 */
    

    /*Get the value of firstname*/ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /*Set the value of firstname*/ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /*Get the value of lastname*/ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /*Set the value of lastname*/ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /*Get the value of email*/ 
    public function getEmail()
    {
        return $this->email;
    }

    /*Set the value of email*/ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /*Get the value of password*/ 
    public function getPassword()
    {
        return $this->password;
    }

    /*Set the value of password*/ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /*Get the value of role*/ 
    public function getRole()
    {
        return $this->role;
    }

    /*Set the value of role*/ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /*Get the value of status*/ 
    public function getStatus()
    {
        return $this->status;
    }

    /*Set the value of status*/ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}