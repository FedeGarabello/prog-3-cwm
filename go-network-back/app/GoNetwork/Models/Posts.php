<?php

namespace GoNetwork\Models;
require_once __DIR__ . '/../../../bootstrap/init.php';
use GoNetwork\DBConnection\DBConnection;
use PDO;
class Posts implements \JsonSerializable {

    private $id;
    private $title;
    private $content;
    private $post_pic;
    private $owner_id;
    private $likes;
    private $category_id;
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
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of post_pic
     */ 
    public function getPostPic()
    {
        return $this->post_pic;
    }

    /**
     * Set the value of post_pic
     *
     * @return  self
     */ 
    public function setPostPic($post_pic)
    {
        $this->post_pic = $post_pic;

        return $this;
    }

    /**
     * Get the value of owner_id
     */ 
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * Set the value of owner_id
     *
     * @return  self
     */ 
    public function setOwnerId($owner_id)
    {
        $this->owner_id = $owner_id;

        return $this;
    }

    /**
     * Get the value of likes
     */ 
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set the value of likes
     *
     * @return  self
     */ 
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

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

    public function getUserByOwerId() {
        $user = new User;
        return $user->getUserById($this->getOwnerId());
    }

    public function jsonSerialize()
    {
        return [
            'id'            => $this->getId(),
            'title'         => $this->getTitle(),
            'content'       => $this->getContent(),
            'post_pic'      => $this->getPostPic(),
            'owner_id'      => $this->getOwnerId(),
            'user_name'     => trim($this->getUserByOwerId()->getName()),
            'last_name'     => trim($this->getUserByOwerId()->getLastName()),
            'profile_pic'   => $this->getUserByOwerId()->getProfilePic(),
            'likes'         => $this->getLikes(),
            'category_id'   => $this->getCategoryId(),
            'created_At'    => $this->getCreatedAt(),

        ];
    }


    public function getAllPosts() {
        $db = DBConnection::getConnection();
        $query = 'SELECT * FROM post ;';
        $stmt = $db->prepare($query);
        $stmt->execute();

        $output = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            $post = new self();
            $post->setId($row['id']);
            $post->setTitle($row['title']);
            $post->setContent($row['content']);
            $post->setPostPic($row['post_pic']);
            $post->setOwnerId($row['owner_id']);
            $post->setLikes($row['likes']);
            $post->setCategoryId($row['category_id']);
            $post->setCreatedAt($row['created_at']);

            $output[] = $post;
        }
        return $output;
    }


    public function getAllPostByUser($owner_id) {
        $db = DBConnection::getConnection();
        $query = 'SELECT * from post
                    WHERE owner_id = ?';
        $stmt = $db->prepare($query);
        $stmt->execute([$owner_id]);

        $output = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            $post = new self();
            $post->setId($row['id']);
            $post->setTitle($row['title']);
            $post->setContent($row['content']);
            $post->setPostPic($row['post_pic']);
            $post->setOwnerId($row['owner_id']);
            $post->setLikes($row['likes']);
            $post->setCategoryId($row['category_id']);
            $post->setCreatedAt($row['created_at']);

            $output[] = $post;
        }
        return $output;
    }
}
