<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'forgot', 'reset']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function forgot(Request $request)
    {
        try {
            $user = User::where(['email' => $request->email])->first();
            Mail::to([$request->email])->send(new ResetPassword($user->name, $request->email));
            return response()->json([
                'status' => true,
                'message' => 'Email enviado com sucesso!'
            ]);
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    public function reset(Request $request)
    {
        try {
            $password = Hash::make($request->password);
            $user = User::where(['reset_password' => $request->token])->first();
            $user->update(['password' => $password]);
            User::where(['reset_password' => $request->token])->update(['reset_password' => null]);
            return response()->json([
                'status' => true,
                'message' => 'Senha alterado com sucesso!'
            ]);
        } catch (\Throwable $th) {
            Log::error('authController: ' . $th->getMessage());
            return response()->json([
                'data' => null,
                'error' => $th->getMessage()
            ]);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 14000
        ]);
    }
}