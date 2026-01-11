<?php

namespace App\models;

class User extends BaseModelUser
{
    private ?int $id = null;

    private string $firstname;

    private string $lastname;

    private string $email;

    private string $password;

    private int $role;

    private ?bool $status = true;

    /*     public function __construct(string $email, string $password, ?string $firstname, ?string $lastname, ?int $role)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
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

    /*Get the value of id*/
    public function getId()
    {
        return $this->id;
    }

    /*Set the value of id*/
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    public function setters()
    {
        if (isset($_POST['firstname'])) {
            $this->setFirstname($_POST['firstname']);
        }
        if (isset($_POST['lastname'])) {
            $this->setLastname($_POST['lastname']);
        }
        $this->setEmail($_POST['email']);
        $this->setPassword($_POST['password']);

        if (isset($_POST['role'])) {
            switch ($_POST['role']) {
                case 'client':
                    $this->setRole(2);
                    break;
                case 'livreur':
                    $this->setRole(3);
                    break;
                case 'admin':
                    $this->setRole(1);
                    break;
            }
        }
    }
}
