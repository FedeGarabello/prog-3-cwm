<?php

namespace GoNetwork\Controllers;

use GoNetwork\Core\App;
use GoNetwork\Core\Route;
use GoNetwork\Core\View;
use GoNetwork\Models\User;


class UserController
{
    public function getUser() {

        $id = Route::getUrlParameters()['id'];

        $posts = (new User())->getUserById($id);
        View::renderJson($posts);
    }

}