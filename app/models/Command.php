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

    private string $status;

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
<<<<<<< HEAD
        $sql = "SELECT * FROM users WHERE id = :user_id LIMIT 1";
        $connexion = Database::getConnexion();
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(":user_id", $_SESSION["user_id"]);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class);
        $user =  $stmt->fetch();

        if(is_null($user)){
            return;
        }else{
            $this->user_id = $user->getId();
        }
=======
        $this->user_id = $_SESSION['user_id'];

        return $this;
>>>>>>> 0ed15000431b6c4821b39ea3d4ddfe82ed57337c
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

<<<<<<< HEAD
        return//code... $this;
=======
        return $this;
>>>>>>> 0ed15000431b6c4821b39ea3d4ddfe82ed57337c
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

<<<<<<< HEAD
    /*Get the value of status*/
=======
    /*Get the value of status*/ 
>>>>>>> 0ed15000431b6c4821b39ea3d4ddfe82ed57337c
    public function getStatus()
    {
        return $this->status;
    }

<<<<<<< HEAD
    /*Set the value of status*/
=======
    /*Set the value of status*/ 
>>>>>>> 0ed15000431b6c4821b39ea3d4ddfe82ed57337c
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }


<<<<<<< HEAD
    public function status()
    {
        $badges = [
            "created" => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Created</span>',
            "pending" => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>',
            "in-treatment" => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">In Treatment</span>',
            "shipped" => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Shipped</span>',
            "finished" => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Finished</span>',
            "cancelled" => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>'
        ];

        $status = $this->getStatus();
        return $badges[$status];
    }
=======
public function status() {
    $badges = [
        "created"=> '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Created</span>',
        "pending"=> '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>',
        "in-treatment"=> '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">In Treatment</span>',
        "shipped"=> '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Shipped</span>',
        "finished"=> '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Finished</span>',
        "cancelled"=> '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>'
    ];

    $status = $this->getStatus();
    return $badges[$status] ?? $badges['pending'];
}

>>>>>>> 0ed15000431b6c4821b39ea3d4ddfe82ed57337c
}
