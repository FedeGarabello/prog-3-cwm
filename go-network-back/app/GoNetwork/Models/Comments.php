<?php

namespace GoNetwork\Models;
require_once __DIR__ . '/../../../bootstrap/init.php';
use GoNetwork\DBConnection\DBConnection;
use PDO;

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
            'id'=> $this->getId(),
            'post_id'=> $this->getPostId(),
            'owner_id'=> $this->getOwnerId(),
            'comment'=> $this->getComment(),
            'created_at'=> $this->getCreatedAt(),
        ];
    }

    public function getAllCommentsByPost($post_id) {
        $db = DBConnection::getConnection();
        $query = 'SELECT * from comment
                WHERE post_id = ?';

        $stmt = $db->prepare($query);
        $stmt->execute([$post_id]);

        $output = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $post = new self();
            $post->setId($row['id']);
            $post->setPostId($row['post_id']);
            $post->setOwnerId($row['owner_id']);
            $post->setComment($row['content']);
            $post->setCreatedAt($row['created_at']);
            $output[] = $post;
        }
        return $output;
    }
}
