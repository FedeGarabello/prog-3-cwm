<?php

namespace GoNetwork\Models;
require_once __DIR__ . '/../../../bootstrap/init.php';
use GoNetwork\DBConnection\DBConnection;
use PDO;

class User extends Model implements \JsonSerializable {

    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = 'user';

    /** @var string El nombre del campo que es la PK. */
    protected $primaryKey = 'id';
    
    /** @var array La lista de atributos/campos de la tabla que se mapean con las propiedades del Modelo. */
    protected $attributes = [
        'id',
        'name',
        'last_name',
        'email',
        'password',
        'gender_id',
        'created_at',
    ];
    
    private $id;
    private $name;
    private $last_name;
    private $email;
    private $password;
    private $gender_id;
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
            'created_at'    => $this->getCreatedAt()
        ];
    }

    public function getUser($row)
    {
        $user = new self();
        $user->setId($row['id']);
        $user->setName($row['name']);
        $user->setLastName($row['last_name']);
        $user->setEmail($row['email']);
        $user->setGenderId($row['gender_id']);
        $user->setCreatedAt($row['created_at']);

        return $user;
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
            $user->setCreatedAt($row['created_at']);

            $output = $user;
        }
        return $output;

    }

    public function createUser($data) {

        $hashPA = password_hash($data['password'], PASSWORD_DEFAULT);
        $db = DBConnection::getConnection();

        $query = "INSERT INTO 'user' ('name', 'last_name', 'email', 'password', 'gender_id') 
                VALUES (:name, :last_name, :email, :password, :gender_id)";

        $stmt = $db->prepare($query);

        if(!$stmt->execute([
            "name"          => $data['name'],
            "last_name"     => $data['last_name'],
            "email"         => $data['email'],
            "password"      => $hashPA,
            "gender_id"     => $data['gender_id']
        ])){
            return [
                'success' => false,
                'msg' => 'Error al crear el usuario'
            ];
        };

        return [
            'success' => true,
            'msg' => 'El usuario fue creado con éxito'
        ];
    }


    public function editUser($data) {
        $db = DBConnection::getConnection();

        $query = "UPDATE 'goNetwork'.'user' 
                    SET 'name' = :name, 'last_name' = :last_name, 'email' = :email, 
                        'gender_id' = :gender_id 
                    WHERE ('id' = :id);";

        $stmt = $db->prepare($query);

        if(!$stmt->execute([
            "id"            => $data['id'],
            "name"          => $data['name'],
            "last_name"     => $data['last_name'],
            "email"         => $data['email'],
            "gender_id"     => $data['gender_id']
        ])){
            return [
                'success' => false,
                'msg' => 'Error al editar el usuario'
            ];
        };

        return [
            'success' => true,
            'msg' => 'El usuario fue editado con éxito'
        ];
    }

    public function getAllContacts(){
        $db = DBConnection::getConnection();
        $query = 'SELECT * from user';
        $stmt = $db->prepare($query);
        $stmt->execute();

        $output = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            $user = new self();
            $user->setId($row['id']);
            $user->setName($row['name']);
            $user->setLastName($row['last_name']);
            $user->setEmail($row['email']);
            $user->setGenderId($row['gender_id']);
            $user->setCreatedAt($row['created_at']);

            $output[] = $user;
        }
        return $output;
    }

    public function generatePassword($password){
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        return $passwordHash;
    }
    

}
