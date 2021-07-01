<?php

namespace GoNetwork\Models;

require_once __DIR__ . '/../../../bootstrap/init.php';


use GoNetwork\DBConnection\DBConnection;
use PDO;
use stdClass;
use GoNetwork\Auth\Auth;
use GoNetwork\Auth\TokenService;

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


    /**
     * Get all post from DB
     * @return Array con objetos Post
     */
    public function getAllPosts() {

        $db = DBConnection::getConnection();
        $query = 'SELECT 
                p.*, c.name as name FROM post p
                INNER JOIN category c on p.category_id = c.id
                WHERE is_active = 1
                order by created_at desc';
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        $output = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $categories = new stdClass();
            $categories->id = $row['category_id'];
            $categories->name = $row['name'];

            $post = new self();
            $post->setId($row['id']);
            $post->setTitle($row['title']);
            $post->setContent($row['content']);
            $post->setPostPic($row['post_pic']);
            $post->setOwnerId($row['owner_id']);
            $post->setLikes($row['likes']);
            $post->setCategoryId($categories);
            $post->setCreatedAt($row['created_at']);

            $output[] = $post;
        }
        sleep(1.2);
        return $output;
    }


    /**
     * Bring all the post by the user given.
     * @param $owner_id
     * @return array
     */
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

        /**
     * Bring all the post by the user given.
     * @param $owner_id
     * @return array
     */
    public function getPostById($id) {

        $db = DBConnection::getConnection();
        $query = 'SELECT * from post
                    WHERE id = ?';
        $stmt = $db->prepare($query);
        if(!$stmt->execute([$id])) {
            return null;
        };

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $post = new self();
        $post->setId($row['id']);
        $post->setTitle($row['title']);
        $post->setContent($row['content']);
        $post->setPostPic($row['post_pic']);
        $post->setOwnerId($row['owner_id']);
        $post->setLikes($row['likes']);
        $post->setCategoryId($row['category_id']);
        $post->setCreatedAt($row['created_at']);

        return $post;
    }

    public function editPostById($data) {

        $auth = new Auth();
        $tokenCookie = $auth->getUserToken();


        $validateToken = new TokenService();
        $validateToken->validateToken($tokenCookie);

        if (!$validateToken){
            return false;
        }

        if ($data['post_pic'] === null) {
            $data['post_pic'] = "post_pic.jpg";
        }

        $db = DBConnection::getConnection();
        $query = 'UPDATE post SET `title` = :title, `content` = :content, `post_pic` = :post_pic, 
                `category_id` = :category_id
                WHERE (`id` = :id);';
        $stmt = $db->prepare($query);

        if(!$stmt->execute([
            'id'            => $data['id'],
            "title"         => $data['title'],
            "content"       => $data['content'],
            "category_id"   => $data['category_id'],
            "post_pic"      => $data['post_pic']
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

    /**
     * Create a new post with the provided data - title, content, owner_id, post_pic & category_id -
     * @param $data
     * @return array
     */
    public function createPost($data) {
        $auth = new Auth();
        $tokenCookie = $auth->getUserToken();


        $validateToken = new TokenService();
        $validateToken->validateToken($tokenCookie);

        if (!$validateToken){
            return false;
        }

        if ($data['post_pic'] === null) {
            $data['post_pic'] = "post_pic.jpg";
        }

        $db = DBConnection::getConnection();
        $query = 'INSERT INTO post (title, content, owner_id, likes, category_id, post_pic)
                    VALUES (:title, :content, :owner_id, 0, :category_id, :post_pic)';
        $stmt = $db->prepare($query);

        if(!$stmt->execute([
            "owner_id" => $data['owner_id'],
            "title" => $data['title'],
            "content" => $data['content'],
            "category_id" => $data['category_id'],
            "post_pic" => $data['post_pic']
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

    public function deletePost($post_id){
        $auth = new Auth();
        $tokenCookie = $auth->getUserToken();


        $validateToken = new TokenService();
        $validateToken->validateToken($tokenCookie);

        if (!$validateToken){
            return false;
        }

        $db = DBConnection::getConnection();
        $query = 'UPDATE post SET is_active = 0
                    where id = ?';
                    
        $stmt = $db->prepare($query);

        if(!$stmt->execute([$post_id])){
            return [
                'success' => false,
                'msg' => 'Error al borrar el Post'
            ];
        };

        return [
            'success' => true,
            'msg' => 'Post borrado con éxito'
        ];
    }

}
