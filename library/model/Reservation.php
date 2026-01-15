<?php

namespace App\model;

class Reservation
{
    private int $id;
    private Membre $membre;
    private Book $book;
    private string $start_date;
    private string $end_date;
    private ?bool $status = true;


    public function setters(Membre $membre, Book $book)
    {
        $this->setMember($membre)->setBook($book);
    }

    public function find($membre, $book)
    {

        $sql = 'SELECT FROM reservations WHERE membre = :membre AND book = :book';
        $connexion = DB::getConnexion();
        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':membre', $membre->getId());
        $stmt->bindParam(':book', $book->getId());

        $stmt->execute();

        /* setfetchmod(fetch::class, Reservations::class); */
        return $stmt->fetch();
    }

    public function getid()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getMember()
    {
        return $this->membre;
    }
    public function setMember($membre)
    {
        $this->membre = $membre;
        return $this;
    }

    public function getBook()
    {
        return $this->book;
    }
    public function setBook($book)
    {
        $this->book = $book;
        return $this;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;
        return $this;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
