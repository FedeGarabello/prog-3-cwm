<?php

namespace GoNetwork\Controllers;

use GoNetwork\Core\App;
use GoNetwork\Core\Route;
use GoNetwork\Core\View;
use GoNetwork\Models\Posts;


class PostsController
{
    public function listAll() {
        $posts = (new Posts())->getAllPosts();
        View::renderJson($posts);
    }

    /**
     * Recibe un objeto POST para insertar
     * @return boolean
     */
    public function createNewPost() {
        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);


        $post = (new Posts())->createPost($postData);
        View::renderJson($post);

    }
}