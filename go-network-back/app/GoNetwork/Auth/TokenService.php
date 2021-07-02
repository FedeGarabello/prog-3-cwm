<?php
namespace GoNetwork\Auth;

use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use GoNetwork\Core\App;
require_once __DIR__ . '/../../../vendor/autoload.php';

class TokenService {

    public function configToken(){
        $key = App::getEnv('TOKEN_KEY');
        // Config.
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded($key)
        );

        return $config;
    }

    public function createToken($id)
    {
        $config = $this->configToken();

        // Builder.
        $builder = $config->builder();

        $token = $builder
                    ->issuedBy('https://gonetwork.com')
                    ->issuedAt(new DateTimeImmutable())
                    ->withClaim('id', $id)
                    ->getToken($config->signer(), $config->signingKey());

        return $token->toString();
    }

    public function validateToken($tokenString) {

        $config = $this->configToken();
        $token = $config->parser()->parse($tokenString);
        
        $constraint = [
            new SignedWith($config->signer(), $config->signingKey()),
            new IssuedBy('https://gonetwork.com')
        ];
        
        $config->validator()->assert($token, ...$constraint);

        if($token->claims()->get('id')){
            return [
                'id' => $token->claims()->get('id')
            ];
        } else {
            return [
                'error' => 'El token es inválido'
            ];
        }

    }
}