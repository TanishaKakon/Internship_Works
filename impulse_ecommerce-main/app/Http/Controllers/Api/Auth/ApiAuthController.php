<?php

namespace App\Http\Controllers\Api\Auth;

use Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:4',
        ]);
        if ($validator->fails()) {
            return response()->json(Helper::generate_response('FAILED', $validator->errors()->toArray()), Response::HTTP_BAD_REQUEST);
        }
        try {
            if (!$token = auth()->attempt($validator->validated())) {
                return response()->json(Helper::generate_response('FAILED', 'Unauthorized'), Response::HTTP_UNAUTHORIZED);
            }
            return $this->createNewToken($token);
        } catch (\Exception $e) {
            return response()->json(Helper::generate_response('FAILED', 'Server Error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:4',
        ]);
        if ($validator->fails()) {
            return response()->json(Helper::generate_response('FAILED', $validator->errors()->toArray()), Response::HTTP_BAD_REQUEST);
        }
        try {
            $user = User::create(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)]
            ));

            return response()->json(Helper::generate_user_response('SUCCESS', 'User successfully registered', $user), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(Helper::generate_response('FAILED', 'Server Error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ], 200);
    }
}
