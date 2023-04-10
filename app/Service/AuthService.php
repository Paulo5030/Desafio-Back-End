<?php

namespace App\Service;

use App\Repositories\AuthRepository;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use App\Traits\ValidateProviderTrait;
use Illuminate\Support\Facades\Hash;


class AuthService
{
    use ValidateProviderTrait;
    public function __construct(protected AuthRepository $authRepository)
    {

    }

    /**
     * @throws AuthenticationException
     * @throws AuthorizationException
     * @throws Exception
     */
    public function authenticate(string $provider, array $fields):array // autenticar
    {
        $selectProvider = $this->getProvider($provider);

        $model = $this->authRepository->findByEmail($selectProvider, $fields['email']);

        if (!$model) {
            throw new AuthorizationException('Wrong credentials', 401);
        }

        if (!Hash::check($fields['password'], $model->password)) {
            throw new AuthorizationException('Wrong credentials', 401);
        }

        $createToken = $model->createToken($provider);

        return [
            'access_token' => $createToken->accessToken,
            'expires_at' => $createToken->token->expires_at,
            'provider' => $provider
        ];

    }
}