<?php

namespace GoNetwork\Models;
require_once __DIR__ . '/../../../bootstrap/init.php';
use GoNetwork\DBConnection\DBConnection;
use PDO;

class User implements \JsonSerializable {
    
    private $id;
    private $name;
    private $last_name;
    private $email;
    private $password;
    private $gender_id;
    private $birth_date;
    private $country_id;
    private $profile_pic;
    private $created_at;

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

    public function jsonSerialize() {
        return [
            'id'            => $this->getId(),
            'name'          => $this->getName(),
            'last_name'     => $this->getLastName(),
            'email'         => $this->getEmail(),
            'password'      => $this->getPassword(),
            'gender_id'     => $this->getGenderId(),
            'birth_date'    => $this->getBirthDate(),
            'country_id'    => $this->getCountryId(),
            'profile_pic'   => $this->getProfilePic(),
            'created_at'    => $this->getCreatedAt()
        ];
    }

    public function getUserById($id)
    {
        $db = DBConnection::getConnection();
        $query = "SELECT * FROM user
                    WHERE id = ?";

        $stmt = $db->prepare($query);
        if (!$stmt->execute([$id])) {
            return null;
        };

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $user = new self();
        $user->setId($row['id']);
        $user->setName($row['name']);
        $user->setLastName($row['last_name']);
        $user->setEmail($row['email']);
        $user->setPassword($row['password']);
        $user->setGenderId($row['gender_id']);
        $user->setBirthDate($row['birth_date']);
        $user->setCountryId($row['country_id']);
        $user->setProfilePic($row['profile_pic']);
        $user->setCreatedAt($row['created_at']);

        return $user;
    }


    /**
     * Traigo el objeto User si el email se encuentra en la DB
     *
     * @param $email
     * @return User|null
     */
    public function userByEmail($email)
    {
        $db = DBConnection::getConnection();
        $query = "SELECT * FROM user
                    WHERE email = ?";
        $stmt = $db->prepare($query);
        if (!$stmt->execute([$email])) {
            return null;
        };

        $output = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $user = new self();
            $user->setId($row['id']);
            $user->setName($row['name']);
            $user->setLastName($row['last_name']);
            $user->setEmail($row['email']);
            $user->setPassword($row['password']);
            $user->setGenderId($row['gender_id']);
            $user->setBirthDate($row['birth_date']);
            $user->setCountryId($row['country_id']);
            $user->setProfilePic($row['profile_pic']);
            $user->setCreatedAt($row['created_at']);

            $output = $user;
        }
        return $output;

    }

    public function createUser($data) {

        $db = DBConnection::getConnection();

        $query = "INSERT INTO `user` (`name`, `last_name`, `email`, `password`, `gender_id`, `birth_date`, `country_id`, `profile_pic`) 
                VALUES (:name, :last_name, :email, :password, :gender_id, :birth_date, :country_id, :profile_pic)";

        $stmt = $db->prepare($query);

        if(!$stmt->execute([
            "name"          => $data['name'],
            "last_name"     => $data['last_name'],
            "email"         => $data['email'],
            "password"      => $data['password'],
            "gender_id"     => $data['gender_id'],
            "birth_date"    => '1986-09-20',
            "country_id"    => $data['country_id'],
            "profile_pic"   => "profile.jpg"
        ])){
            return [
                'success' => false,
                'msg' => 'Error al crear al usuario'
            ];
        };

        return [
            'success' => true,
            'msg' => 'El usuario fue creado con exito'
        ];
    }

    public function generatePassword($password){
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        return $passwordHash;
    }
    

}
