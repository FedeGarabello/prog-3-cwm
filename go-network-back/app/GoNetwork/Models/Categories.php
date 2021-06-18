<?php

namespace GoNetwork\Models;

require_once __DIR__ . '/../../../bootstrap/init.php';
use GoNetwork\DBConnection\DBConnection;
use PDO;


class Categories {
    
    protected $category_id;
    protected $category_name;

    /**
     * Get the value of category_id
     */ 
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Get the value of category_name
     */ 
    public function getCategoryName()
    {
        return $this->category_name;
    }

    /**
     * Set the value of category_name
     *
     * @return  self
     */ 
    public function setCategoryName($category_name)
    {
        $this->category_name = $category_name;

        return $this;
    }
} 