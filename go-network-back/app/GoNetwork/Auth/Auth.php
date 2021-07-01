<?php
namespace GoNetwork\Auth;
require_once __DIR__ . '/../../../bootstrap/init.php';
use GoNetwork\Models\User;
use GoNetwork\Auth\TokenService;
class Auth
{
    /**
     * Get the user by email.
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
            if(password_verify($password, $user->getPassword())) {
                $this->setAsAuthenticated($user);
                return true;
            }
        } 
        return false;
    }

    /**
     * 
     * @param $user
     */
    public function setAsAuthenticated($user)
    {
        $tokenService = new TokenService();
        $token = $tokenService->createToken($user->getId());

        setcookie('token', $token, 0, "", "", false, true);

        echo json_encode([
            'success' => true,
            'data' => [
                'id'    => $user->getId(),
                'email' => $user->getEmail()
            ]
        ]);
    }

    /**
     * Logout User
     */
    public function logout()
    {
        setcookie('token', null, time() - 3600 * 24);

        echo json_encode([
            'success' => true,
        ]);
    }

    /**
     * 
     *
     * @return bool
     */
    public function getUserToken()
    {
        $token = $_COOKIE['token'] ?? null;
        return $token;
    }
}
