<?php
namespace Auth;

use GoNetwork\User\User;

class Auth
{
    /**
     * Realizamos la validacion del usuario buscandolo por el email
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): bool
    {
        $user = new User();
        $user = $user->userByEmail($email);

        if($user) {
            if(password_verify($password, $user['pass'])) {
                $this->setAsAuthenticated($user['id_usuario']);
                return true;
            }
        } 
        return false;
    }



    /**
     * Marca el $user como autenticado.
     *
     * @param $user
     */
    public function setAsAuthenticated($user)
    {
        $_SESSION['id'] = $user;
    }

    /**
     * Desloguea al usuario.
     */
    public function logout(): void
    {
        unset($_SESSION['id']);
    }

    /**
     * Retorna si el usuario está autenticado o no.
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return isset($_SESSION['id']);
    }



    /**
     * Retorna el usuario autenticado.
     * Si no está autenticado, retorna null.
     *
     * @return Usuario|null
     */
    public function getUser()
    {
        if(!$this->isAuthenticated()) {
            return null;
        }

        $usuario = new Usuario;
        return $usuario->getUserById($_SESSION['id']);
    }
}
