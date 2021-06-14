<?php

namespace GoNetwork\Models;

class User {
    
    protected $id;
    protected $name;
    protected $last_name;
    protected $email;
    protected $password;
    protected $gender_id;
    protected $birth_date;
    protected $country_id;
    protected $profile_pic;
    protected $created_at;

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
     * Get the value of last_name
     */ 
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     *
     * @return  self
     */ 
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of gender_id
     */ 
    public function getGenderId()
    {
        return $this->gender_id;
    }

    /**
     * Set the value of gender_id
     *
     * @return  self
     */ 
    public function setGenderId($gender_id)
    {
        $this->gender_id = $gender_id;

        return $this;
    }

    /**
     * Get the value of birth_date
     */ 
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * Set the value of birth_date
     *
     * @return  self
     */ 
    public function setBirthDate($birth_date)
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    /**
     * Get the value of country_id
     */ 
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * Set the value of country_id
     *
     * @return  self
     */ 
    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;

        return $this;
    }

    /**
     * Get the value of profile_pic
     */ 
    public function getProfilePic()
    {
        return $this->profile_pic;
    }

    /**
     * Set the value of profile_pic
     *
     * @return  self
     */ 
    public function setProfilePic($profile_pic)
    {
        $this->profile_pic = $profile_pic;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }
}
