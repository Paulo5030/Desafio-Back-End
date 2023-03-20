<?php

namespace App\Http\Controllers;

use App\Service\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct( AuthService $authService)
    {
        $this->authService = $authService;
    }
    //autenticando o usuario
    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function authenticate(Request $request, string $provider) // autenticacao
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $fields = $request->only(['email', 'password']);

        $result = $this->authService->authenticate($provider, $fields);
        return response()->json($result);
    }
}
