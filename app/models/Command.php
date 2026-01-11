<?php

namespace App\models;

class Command extends BaseModelCommand
{
    private int $id;

    private string $title;

    private string $details;

    private int $user_id;

    private string $address;

    private string $created_date;

    /*     public function __construct($title, $details, $user_id)
    {
        $this->title = $title;
        $this->details = $details;
        $this->user_id = $user_id;
    } */



    /*Get the value of title*/
    public function getTitle()
    {
        return $this->title;
    }

    /*Set the value of title*/
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /*Get the value of details*/
    public function getDetails()
    {
        return $this->details;
    }

    /*Set the value of details*/
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /*Get the value of user_id*/
    public function getUser_id()
    {
        return $this->user_id;
    }

    /*Set the value of user_id*/
    public function setUser_id()
    {
        $this->user_id = $_SESSION['user_id'];

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

    /*Get the value of address*/
    public function getAddress()
    {
        return $this->address;
    }

    /*Set the value of address*/
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /*Get the value of created_date*/
    public function getCreated_date()
    {
        return $this->created_date;
    }

    /*Set the value of created_date*/
    public function setCreated_date($created_date)
    {
        $this->created_date = $created_date;

        return $this;
    }



    private function setters()
    {
        if (isset($_POST['title'])) {
            $this->setTitle($_POST['title']);
        }
        if (isset($_POST['details'])) {
            $this->setDetails($_POST['details']);
        }

        if (isset($_POST['address'])) {
            $this->setAddress($_POST['address']);
        }

        $this->setUser_id();
    }


    public function afterMath()
    {
        $this->setters();
        if ($this->validate()) {
            $_SESSION['flash']['errorInput'] = 'No special charachters are allowed other than " . - _ " ';
            return;
        }
        $this->save();
    }
}
