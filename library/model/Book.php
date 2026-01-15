<?php

namespace App\model;



class Book{
    private int $id;
    private string $name;
    private Author $author;
    private int $pages;
    private Category $category;



    public function setters(string $name, Author $author, int $pages, Category $category){
        $this->setName($name)->setAuthor($author)->setPages($pages)->setCategory($category);
        
    }

public function find($name,$author)
    {
        $sql = 'SELECT FROM books WHERE name = :name AND author = :author';
        $connexion = DB::getConnexion();
        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':author', $author->getId());
        
        $stmt->execute();

        /* setfetchmod(fetch::class, Book::class); */
        return $stmt->fetch();
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of author
     */ 
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */ 
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of pages
     */ 
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set the value of pages
     *
     * @return  self
     */ 
    public function setPages($pages)
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
}