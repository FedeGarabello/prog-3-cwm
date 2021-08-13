<?php

namespace GoNetwork\Controllers;


use GoNetwork\Auth\Auth;
use GoNetwork\Core\App;
use GoNetwork\Core\Route;
use GoNetwork\Core\View;
use GoNetwork\DB\QueryException;
use GoNetwork\Debug\Debug;
use GoNetwork\Models\Favorites;
use GoNetwork\Models\Friends;
use GoNetwork\Storage\FileUpload;
use GoNetwork\Storage\InvalidFileTypeException;
use GoNetwork\Storage\Session;
use GoNetwork\Validation\Validator;

class FavoritesController extends Controller
{
    public function getFavorites()
    {
        $id = Route::getUrlParameters()['id'] ;
        $favorites = (new Favorites())->getFavoritesByPK($id);

        View::renderJson($favorites);
    }

    /**
     * Método vacío para la petición para OPTIONS de CORS.
     */
    public function empty() {}
}
