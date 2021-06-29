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

        if($postData['profile_pic'] != null || $postData['profile_pic'] != '') {
            $imagenParts = explode(',', $postData['profile_pic']);
            $imagenDecoded = base64_decode($imagenParts[1]);
            $imagenNombre =  time(). ".jpg";
            file_put_contents( "./../imgs/" . $imagenNombre, $imagenDecoded);
            $postData['profile_pic'] = $imagenNombre;
        }

        $user = (new User())->createUser($postData);
        View::renderJson($user);
    }
}