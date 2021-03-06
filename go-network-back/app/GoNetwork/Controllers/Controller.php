<?php

namespace GoNetwork\Controllers;


use GoNetwork\Auth\Auth;
use GoNetwork\Core\App;

class Controller
{
    /** @var Auth */
    protected $auth;

    public function __construct()
    {
        $this->auth = new Auth;
    }

    /**
     * Verifica que el usuario esté autenticado.
     * De no estarlo, lo redirecciona al form de login.
     */
    protected function requiresAuth()
    {
        if(!$this->auth->isAuthenticated()) {
            $_SESSION['status_error'] = 'Tenés que iniciar sesión para poder realizar esta acción.';
            App::redirect('iniciar-sesion');
        }
    }
}
