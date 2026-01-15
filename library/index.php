<?php

use App\model\Author;
use App\model\Book;
use App\model\Category;
use App\model\Membre;

require '../vendor/autoload.php';



$membre = new Membre();
$membre->setters('Alex', 'Jhones', 'alex@email.com', '0');

$author = new Author();
$author->setters('JRR', 'Tolkein');

$category = new Category();
$category->setters("Fantasy");

$book= new Book();
$book->setters('Lord of the Rings', $author, '245', $category);
echo '<pre>';
var_dump($membre);
echo '<pre>';











/* --- MON GLOSSAIRE PERSO DU SPRINT ---

- Classe : the skeleton of an object, used to creat an object based on it.
    
- Objet : an instansiation of a class
    
- Héritage : when a class inherites the properties and methods of another class, creating a parent son relation
    
- Encapsulation : making all properties in a class private or protected if its used for inheritence, for saftey reason and geting its info using setters and getters
    
- Abstraction : a generalisation of properties or methods in a class, used when there are multiple classes sharing the same properties or methods
    
- Polymorphisme : when an object can do 2 different things based on a condition
    
- Static :  a keyword thats writen next to the visibility keyword, letes you access the propiety or method using it with out creating an object from its class
    
- Self vs Parent : Self returns the class itself, Parent returns the parent class it self
    
- Methode et attribut static : static method can be used with out creating an object from the class, Class::Method
    
- Méthodes magiques :   __DIR__, __CONSTRUCT, __DESTROY
    
- Super Globales :  $_GET, $_POST, $_SESSION, $_SERVER,
    
- PDO : a predefined class in php which letes you comunicate with PDO driver
    
- pdo->execute : to execute a sql syntaxe
    
- pdo->bindparam :  used for inserting values into the sql syntaxe, replacing the placeholder ones
    
- pdo->bindvalue : 
    
- PDO Statement : 
    
- pdo->fetch :  fetching data from the DB when using an sql syntax that fetches like SELECT, it fetches based on the defines FetchMod, fetch gets only 1 row, the top one if theres many
    
- Retourner le dernier ID : returns last inserteted id in the DB 
*/