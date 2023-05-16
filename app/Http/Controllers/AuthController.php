<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Service\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }
    //autenticando o usuario
    /**
     * @throws Exception
     */
    public function authentication(AuthRequest $request, string $provider): JsonResponse // autenticacao
    {
        $fields = $request->all();
        $result = $this->authService->authenticate($provider, $fields);
        return response()->json($result);
    }
}
