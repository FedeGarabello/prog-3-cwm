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
}