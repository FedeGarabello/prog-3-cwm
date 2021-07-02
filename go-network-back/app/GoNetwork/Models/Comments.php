<?php

namespace GoNetwork\Models;
require_once __DIR__ . '/../../../bootstrap/init.php';
use GoNetwork\DBConnection\DBConnection;
use PDO;
use stdClass;
use GoNetwork\Auth\Auth;


class Comments implements \JsonSerializable{
    
    private $id;
    private $post_id;
    private $owner_id;
    private $comment;
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
     * Get the value of postId
     */ 
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * Set the value of postId
     *
     * @return  self
     */ 
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;

        return $this;
    }

    /**
     * Get the value of ownerId
     */ 
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * Set the value of ownerId
     *
     * @return  self
     */ 
    public function setOwnerId($owner_id)
    {
        $this->owner_id = $owner_id;

        return $this;
    }

    /**
     * Get the value of comment
     */ 
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */ 
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id'            => $this->getId(),
            'post_id'       => $this->getPostId(),
            'owner_id'      => $this->getOwnerId(),
            'comment'       => $this->getComment(),
            'created_at'    => $this->getCreatedAt(),
        ];
    }

    public function getAllCommentsByPost($post_id) {
        $db = DBConnection::getConnection();
        $query = 'SELECT c.*, u.name as name, u.last_name as last_name FROM `comment` c
                INNER JOIN `user` u ON c.owner_id = u.id
                WHERE c.post_id = ?';

        $stmt = $db->prepare($query);
        $stmt->execute([$post_id]);

        $output = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $categories = new stdClass();
            $categories->name = $row['name'];
            $categories->last_name = $row['last_name'];
            $categories->owner_id = $row['owner_id'];

            $post = new self();
            $post->setId($row['id']);
            $post->setPostId($row['post_id']);
            $post->setOwnerId($categories);
            $post->setComment($row['content']);
            $post->setCreatedAt($row['created_at']);
            $output[] = $post;
        }
        return $output;
    }

    public function createComment($data) {

        $auth = new Auth();
        if(!$auth->validateTokenForUser()){
            return [
                'msg' => 'No hemos podido validar al usuario'
            ];
        }

        $db = DBConnection::getConnection();
        $query = 'INSERT INTO comment (post_id, owner_id, content)
                    VALUES (:post_id, :owner_id, :content)';

        $stmt = $db->prepare($query);

        if(!$stmt->execute([
            "post_id"   => $data['post_id'],
            "owner_id"  => $data['owner_id'],
            "content"   => $data['content'],
        ])){
            return [
                'success' => false,
                'msg' => 'Error al crear el Post'
            ];
        };

        return [
            'success' => true,
            'msg' => 'Post creado con éxito'
        ];
    }

    public function deleteComment($id) {
        $auth = new Auth();
        if(!$auth->validateTokenForUser()){
            return [
                'msg' => 'No hemos podido validar al usuario'
            ];
        }

        $db = DBConnection::getConnection();
        $query = 'DELETE FROM comment WHERE id = ?';

        $stmt = $db->prepare($query);

        if(!$stmt->execute([$id])){
            return [
                'success' => false,
                'msg' => 'Error al borrar el comentario'
            ];
        };

        return [
            'success' => true,
            'msg' => 'Comentario borrado con éxito'
        ];
    }
}
