<?php

namespace App\Http\Controllers;

use App\Service\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
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
