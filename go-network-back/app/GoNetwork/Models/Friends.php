<?php

namespace GoNetwork\Models;

use GoNetwork\DBConnection\DBConnection;
use JsonSerializable;
use PDO;

//Agregar/quitar usuarios a un lista de amigos, para poder luego ver sus publicaciones de manera separada.
// Esta clase transforma el id_friend en un objeto User.



class Friends extends Model implements \JsonSerializable
{
    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = 'user_has_friend';

    /** @var string El nombre del campo que es la PK. */
    protected $primaryKey = 'id_user';

    /** @var array La lista de atributos/campos de la tabla que se mapean con las propiedades del Modelo. */
    protected $attributes = [
        'id_user',
        'id_friend',
        'state',
        'created_at',
    ];

    private $id_user;
    private $id_friend;
    private $state;
    private $created_at;

    public function jsonSerialize()
    {
        return [
            'id_user'       =>$this->getIdUser(),
            'id_friend'     =>$this->getIdFriend(),
            'state'         =>$this->getState(),
            'created_at'     =>$this->getCreatedAt(),
        ];
    }

    /**
     * Retorna el registro asociado a la PK.
     *
     * @param mixed $id
     * @return static|null
     */
    public function getFriendsByPK($id)
    {
        $db = DBConnection::getConnection();

        // Para evitar multiples querys ya traigo los valores que luego cargo con la funcion getUser.
        $query = "SELECT uhf.*, u.id, u.name, u.last_name, u.email, u.gender_id, u.birth_date, u.profile_pic, u.created_at
                    FROM " . $this->table . " uhf
                    JOIN USER u ON uhf.id_friend = u.id
                    WHERE " . $this->primaryKey . " = ?";

/*
        $query = "SELECT *
                    FROM " . $this->table . "
                    WHERE " . $this->primaryKey . " = ?";
*/
        try {
            $stmt = $db->prepare($query);
            $stmt->execute([$id]);

            $exit = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $friend = (new User())->getUser($row);

                $exit[] = $friend;
                /*
                $exit[] = [
                    'user' => (new User())->getUserById($row['id_friend']),
                    'state' => $row['state'],
                    'created_at' => $row['created_at']
                ];
                */

            }

        } catch(PDOException $e) {
            throw new QueryException($query, [$id], $stmt->errorInfo(), $e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $exit;
        //return $stmt->fetchObject(static::class);
    }



    // INICIO DE GETTER & SETTER
    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user): void
    {
        $this->id_user = $id_user;
    }

    /**
     * @return mixed
     */
    public function getIdFriend()
    {
        return $this->id_friend;
    }

    /**
     * @param mixed $id_friend
     */
    public function setIdFriend($id_friend): void
    {
        $this->id_friend = $id_friend;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }


}