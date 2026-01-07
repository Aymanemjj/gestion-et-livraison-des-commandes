<?php

namespace App\models;

class Offer extends BaseModelOffer{
    private int $id;

    private int $price;

    private string $completion_date;

    private string $delivery_type;

    private int $vehicule;

    private int $command_id;

    private int $user_id;

/*     public function __construct($price, $completion_date, $delivery_type, $vehicule, $command_id, $user_id)
    {
        $this->price = $price;
        $this->completion_date = $completion_date;
        $this->delivery_type = $delivery_type;
        $this->vehicule = $vehicule;
        $this->command_id = $command_id;
        $this->user_id = $user_id;
    } */



    /*Get the value of price*/ 
    public function getPrice()
    {
        return $this->price;
    }

    /*Set the value of price*/ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /*Get the value of completion_date*/ 
    public function getCompletion_date()
    {
        return $this->completion_date;
    }

    /*Set the value of completion_date*/ 
    public function setCompletion_date($completion_date)
    {
        $this->completion_date = $completion_date;

        return $this;
    }

    /*Get the value of delivery_type*/ 
    public function getDelivery_type()
    {
        return $this->delivery_type;
    }

    /*Set the value of delivery_type*/ 
    public function setDelivery_type($delivery_type)
    {
        $this->delivery_type = $delivery_type;

        return $this;
    }

    /*Get the value of vehicule*/ 
    public function getVehicule()
    {
        return $this->vehicule;
    }

    /*Set the value of vehicule*/ 
    public function setVehicule($vehicule)
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    /*Get the value of command_id*/ 
    public function getCommand_id()
    {
        return $this->command_id;
    }

    /*Set the value of command_id*/ 
    public function setCommand_id($command_id)
    {
        $this->command_id = $command_id;

        return $this;
    }

    /*Get the value of user_id*/ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /*Set the value of user_id*/ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of id
     */ 
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
}