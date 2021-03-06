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
        $user = (new User())->getUserById($id);
        View::renderJson($user);
    }

    public function createUser() {
        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        $user = (new User())->createUser($postData);
        View::renderJson($user);
    }

    public function editUser() {
        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        $user = (new User())->editUser($postData);
        View::renderJson($user);
    }

    public function getAllUsers(){
        $id = Route::getUrlParameters()['id'];
        $users = (new User())->getAllContacts($id);
        View::renderJson($users);
    }
    
    public function empty() {

    }
}