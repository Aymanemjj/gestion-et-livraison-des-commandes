<?php

namespace App\model;

class Manager extends User
{



    public function creatReservation($membre, $book)
    {

        $reservation = new Reservation();
        $reservation->setters($membre, $book);

        $sql = 'INSERT INTO reservations (membre, book) VALUES (:membre, :book)';

        $connexion = DB::getConnexion();
        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':membre', $membre->getId());
        $stmt->bindParam(':book', $book->getId());

        $stmt->execute();
    }
    public function editReservation() {}
    public function deleteReservation($reservation)
    {
        
        $sql = 'DELETE FROM reservations WHERE id = :id';

        $connexion = DB::getConnexion();
        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':id', $reservation->getId());

        $stmt->execute();
    }
    public function addBook($book)
    {


        $sql = "INSERT INTO book (name, pages, author, category) VALUES (:name, :pages, :author, :category)";
        $connexion = DB::getConnexion();

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':name', $book->getName());
        $stmt->bindParam(':pages', $book->getPages());
        $stmt->bindParam(':author', $book->getAuthor());
        $stmt->bindParam(':category', $book->getCategory());

        $stmt->execute();
    }
    public function deleteBook($book)
    {
        $sql = 'DELETE FROM book WHERE id = :id';
        $connexion = DB::getConnexion();
        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':id', $book->getId());

        $stmt->execute();
    }
}
