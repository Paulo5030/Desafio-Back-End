<?php

namespace App\Service;

use App\Exceptions\NotFoundException;
use App\Models\Retailer;
use App\Models\User;
use App\Repositories\AuthRepository;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;


class AuthService
{
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

    /**
     * @throws Exception
     */
    private function getProvider (string $provider): Authenticatable // obter provedor
    {
        if ($provider == "user") {
            return new User();
        }
        if ($provider == "retailer") {
            return new Retailer();
        }
        throw new NotFoundException('Provider not found');
    }
}