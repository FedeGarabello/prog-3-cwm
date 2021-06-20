<?php

namespace GoNetwork\Controllers;

use GoNetwork\Core\App;
use GoNetwork\Core\Route;
use GoNetwork\Core\View;
use GoNetwork\Models\Comments;


class CommentsController
{
    public function getCommentsByPost() {

        $id = Route::getUrlParameters()['id'];
        $posts = (new Comments())->getAllCommentsByPost($id);
        View::renderJson($posts);
    }
}