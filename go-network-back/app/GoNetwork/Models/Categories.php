<?php

namespace GoNetwork\Models;

require_once __DIR__ . '/../../../bootstrap/init.php';
use GoNetwork\DBConnection\DBConnection;
use PDO;


class Categories implements \JsonSerializable {
    
    protected $id;
    protected $name;

    /**
     * Get the value of category_id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of category_name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of category_name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    public function jsonSerialize()
    {
        return [
            'id'   => $this->getId(),
            'name' => $this->getName()
        ];
    }


    public function getAllCategories() {
        $db = DBConnection::getConnection();
        $query = 'SELECT * from category';
        $stmt = $db->prepare($query);
        $stmt->execute();

        $output = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $categories = new self();
            $categories->setId($row['id']);
            $categories->setName($row['name']);

            $output[] = $categories;
        }
        return $output;
    }

} 