<?php

namespace App\Http\Controllers\Api\Private\User\Auth;

use App\Http\Controllers\Controller;
use App\Repository\Interfaces\User\IUserRepository;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserAuthController extends Controller
{
    protected $user;

    public function __construct(IUserRepository $repository)
    {
        $this->user = $repository;
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');

        $token = null;

        if (!$token = auth()->guard('user')->attempt($input)) {
            return $this->outputJSON('', 'Usuário ou senha inválidos', false, 401);
        }

        return $this->outputJSON($token, '', true, 200);
    }

    public function logout(Request $request)
    {
        try {
            auth()->guard('user')->logout();

            return $this->outputJSON([], 'User logged out successfully', false, 200);
        } catch (JWTException $exception) {
            return $this->outputJSON([], $exception->getMessage(), true, 500);
        }
    }

    public function session()
    {
        auth()->user()->update(['last_activity' => now()]);

        return $this->outputJSON(auth()->user(), '', true, 200);
    }
}
