<?php

namespace GoNetwork\Controllers;

use GoNetwork\Auth\Auth;
use GoNetwork\Core\App;
use GoNetwork\Core\Route;
use GoNetwork\Core\View;
use GoNetwork\Models\User;

class AuthController {

    public function login() {

        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        $email = $postData['email'];
        $password = $postData['password'];

        // Validar si no existe.
        $user = new User();
        $user = $user->userByEmail($email);

        $auth = new Auth;

        $auth->login($email, $password);
    }

    public function logout(){

        $auth = new Auth;
        $auth->logout();
    }
}