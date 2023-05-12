<?php

namespace App\Service\Auth;

use App\Repositories\UserAuthRepository;
use App\Traits\ValidateProviderTrait;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use ValidateProviderTrait;

    public function __construct(protected readonly UserAuthRepository $authRepository)
    {
    }

    /**
     * @throws AuthenticationException
     * @throws AuthorizationException
     * @throws Exception
     */
    public function authenticate(string $provider, array $fields): array // autenticar
    {
        $selectProvider = $this->getProvider($provider);

        $model = $this->authRepository->findByEmail($selectProvider, $fields['email']);

        if (!$model || !Hash::check($fields['password'], $model->password)) {
            throw new AuthorizationException('Wrong credentials', StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        $createToken = $model->createToken($provider);

        return [
            'access_token' => $createToken->accessToken,
            'expires_at' => $createToken->token->expires_at,
            'provider' => $provider
        ];
    }
}
