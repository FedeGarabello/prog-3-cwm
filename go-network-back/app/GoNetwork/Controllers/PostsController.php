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
     * @param $data
     * @return boolean
     */
    public function newPost($data) {
        $post = (new Posts())->createPost($data);
        View::renderJson($post);
    }
}