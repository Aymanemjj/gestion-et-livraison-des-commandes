<?php

namespace App\models;

class Command{

    private string $title;

    private string $details;

    private int $user_id;

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
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }
}