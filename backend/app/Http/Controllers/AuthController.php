<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Sukify Documentation",
 *      description="Sukify Swagger OpenApi description",
 *      @OA\Contact(
 *          url="https://github.com/Daizygod/sukify"
 *      )
 * )
 *
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     securityScheme="api_key",
 *     name="Authorization",
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
 *
 * @OA\Server(
 *      url="https://sukify.ru",
 *      description="Deploy API Server"
 * )
 *
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @OA\Post (
     *     path="/api/auth/login",
     *     tags={"auth"},
     *     description="Login (get jwt bearer token)",
     *     summary="Login (get jwt bearer token)",
     *      @OA\RequestBody(
     *          @OA\Property(property="email",type="string",example="test@test.com"),
     *          @OA\Property(property="password",type="string",example="qwerty"),
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                      example="test@test.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                      example="qwerty"
     *                 ),
     *                 example={"email": "test@test.com", "password": "qwerty"}
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzAxMjg5ODk2LCJleHAiOjE3MDEyOTM0OTYsIm5iZiI6MTcwMTI4OTg5NiwianRpIjoiczNkR2RPRENJdzl4QWNXOCIsInN1YiI6IjEwMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.ZE1gFMtIMT3FHZNWIpvPULYBa8ip86arfs-Wf9R_vOs"),
     *              @OA\Property(property="token_type", type="string", example="bearer"),
     *              @OA\Property(property="expires_in", type="integer", example="3600"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Unauthorized"),
     *          )
     *      )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post (
     *     path="/api/auth/me",
     *     tags={"auth"},
     *     security = {{"api_key": {}}},
     *     description="Get info about user by jwt Bearer",
     *     summary="Get info about user",
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="tester"),
     *              @OA\Property(property="email", type="string", example="test@test.com"),
     *              @OA\Property(property="email_verified_at", type="string", example="2022-08-25T08:29:33.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2022-08-25T08:29:33.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2022-08-25T08:29:33.000000Z"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthenticated."),
     *          )
     *      )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post (
     *     path="/api/auth/logout",
     *     tags={"auth"},
     *     security = {{"api_key": {}}},
     *     description="Logout user",
     *     summary="Logout user",
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Successfully logged out"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthenticated."),
     *          )
     *      )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post (
     *     path="/api/auth/refresh",
     *     tags={"auth"},
     *     security = {{"api_key": {}}},
     *     description="Refresh jwt token",
     *     summary="Refresh jwt token",
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS9hdXRoL3JlZnJlc2giLCJpYXQiOjE3MDEyOTkyMzQsImV4cCI6MTcwMTMwMjg0OSwibmJmIjoxNzAxMjk5MjQ5LCJqdGkiOiJJM2JSZ29jQnlHZ0lFNVVJIiwic3ViIjoiMTAxIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.PJnN1ZJgEV6TvxlOMQLFd_KZ4Rh9WajNbgOXzVnP0rY"),
     *              @OA\Property(property="token_type", type="string", example="bearer"),
     *              @OA\Property(property="expires_in", type="integer", example="3600"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthenticated."),
     *          )
     *      )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}