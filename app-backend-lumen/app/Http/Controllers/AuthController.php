<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("auth", ["except" => ["login"]]);
    }

    /**
     * Login the user and return a JWT token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate credentials
        $this->validate($request, [
            "email" => "required|email",
            "password" => "required",
        ]);

        $credentials = $request->only("email", "password");

        // Attempt to generate a token
        try {
            if (!($token = auth()->attempt($credentials))) {
                return response()->json(["error" => "Unauthorized"], 401);
            }
        } catch (\Exception $e) {
            return response()->json(
                ["error" => "Token generation failed: " . $e->getMessage()],
                500
            );
        }

        return response()->json([
            "token" => $token,
            "credentials" => $credentials,
            "token_type" => "bearer",
            "expires_in" => JWTAuth::factory()->getTTL() * 60,
        ]);
    }

    /**
     * Logout the user and invalidate the token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        auth("api")->logout();

        return response()->json(["message" => "Successfully logged out"]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth("api")->refresh());
    }

    /**
     * Get the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return response()->json(auth("api")->user());
    }
}
