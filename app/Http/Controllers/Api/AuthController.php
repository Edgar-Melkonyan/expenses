<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Auth\AuthRepository;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @var $authRepository
     */
    protected $authRepository;

    /**
     * UserController constructor.
     *
     * @param AuthRepository $userRepository
     */
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Login user
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => ['message' => 'These credentials do not match our records']], self::HTTP_UNAUTHORIZED );
        }

        $token = $this->authRepository->login(Auth::user());
        return response()->json(['success' => $token], self::HTTP_OK);
    }

    /**
     * Logout user
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $this->authRepository->logout(Auth::user());
        return response()->json([
            'success' => [
                'message' => 'Successfully logged out'
            ]
        ], self::HTTP_OK);
    }
}
