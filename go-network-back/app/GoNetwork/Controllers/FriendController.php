<?php

namespace GoNetwork\Controllers;


use GoNetwork\Auth\Auth;
use GoNetwork\Core\App;
use GoNetwork\Core\Route;
use GoNetwork\Core\View;
use GoNetwork\DB\QueryException;
use GoNetwork\Debug\Debug;
use GoNetwork\Models\Friends;
use GoNetwork\Storage\FileUpload;
use GoNetwork\Storage\InvalidFileTypeException;
use GoNetwork\Storage\Session;
use GoNetwork\Validation\Validator;

class FriendController extends Controller
{
    public function listFriends()
    {
        $id = Route::getUrlParameters()['id'] ;
        $friends = (new Friends())->getFriendsByPK($id);

        //print_r($friends);
        View::renderJson($friends);
    }

    /**
     * Método vacío para la petición para OPTIONS de CORS.
     */
    public function empty() {}
}
