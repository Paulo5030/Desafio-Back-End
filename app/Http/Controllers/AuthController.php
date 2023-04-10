<?php

namespace App\Http\Controllers;

use App\Service\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    //autenticando o usuario
    /**
     * @throws Exception
     */
    public function authentication(Request $request, string $provider): JsonResponse // autenticacao
    {
        $fields = $request->all();
        $result = $this->authService->authenticate($provider, $fields);
        return response()->json($result);
    }
}
