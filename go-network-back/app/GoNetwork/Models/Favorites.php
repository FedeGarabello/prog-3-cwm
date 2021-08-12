<?php

namespace GoNetwork\Models;

class Favorites extends Model implements \JsonSerializable
{
    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = 'favorites';

    /** @var string El nombre del campo que es la PK. */
    protected $primaryKey = 'user_id';

    /** @var array La lista de atributos/campos de la tabla que se mapean con las propiedades del Modelo. */
    protected $attributes = [
        'id',
        'user_id',
        'post_id',
        'state',
    ];

    private $id;
    private $user_id;
    private $post_id;
    private $state;

    public function jsonSerialize()
    {
        return [
            'id'       =>$this->getId(),
            'user_id'  =>$this->getUserId(),
            'post_id'  =>$this->getPostId(),
            'state'    =>$this->getState(),
        ];
    }


    /**
     * @param $user_id Id del usuario que hace la consulta para traer sus favoritos
     * @return Favorites|null
     */
    public function getFavoritesByPK($user_id)
    {
        $favorites = (new self)->traerPorPK($user_id);
        return $favorites;

    }





    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id): void
    {
        $this->post_id = $post_id;
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


}