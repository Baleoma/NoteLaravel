<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * @OA\Post(
 *     path="/api/register",
 *     summary="Регистрация нового пользователя",
 *     tags={"Auth"},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent (
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="login", type="string", example="Jane Doe3"),
 *                     @OA\Property(property="email", type="email", example="JaneDoe@example.com"),
 *                     @OA\Property(property="password", type="string", example="password123"),
 *                 )
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=13),
 *             @OA\Property(property="login", type="string", example="John Doe2"),
 *             @OA\Property(property="email", type="email", example="JohnDoe2@example.com"),
 *             @OA\Property(property="created_at", type="datetime", example="2025-03-28T11:29:30.000000Z"),
 *             @OA\Property(property="updated_at", type="datetime", example="2025-03-28T11:29:30.000000Z"),
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object", example={"email": {"The email has already been taken."}})
 *         )
 *     )
 * ),
 *
 * @OA\Post(
 *     path="/api/login",
 *     summary="Вход пользователя",
 *     tags={"Auth"},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent (
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="email", type="email", example="JohnDoe@example.com"),
 *                     @OA\Property(property="password", type="string", example="password123"),
 *                 )
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="login", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="email", example="JohnDoe@example.com"),
 *                 @OA\Property(property="created_at", type="datetime", example="2025-03-28T06:40:42.000000Z"),
 *                 @OA\Property(property="updated_at", type="datetime", example="2025-03-28T06:40:42.000000Z"),
 *             ),
 *             @OA\Property(property="token", type="string", example="1|SmGqBeLTc8Ag9YlLYg8eOz8FiTmY55NbrVDXmAtl2ccb2fae"),
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Wrong email or password")
 *         )
 *     )
 * ),
 *
 * @OA\Get(
 *     path="/api/logout",
 *     summary="Выход пользователя",
 *     tags={"Auth"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Response(
 *         response=200,
 *         description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Logged out")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     )
 * )
 */


class AuthController extends Controller
{

    public function login(LoginUserRequest $request) //Работает
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Worng email or password'
            ], 401);
        }

        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken
        ]);
    }

    public function register(StoreUserRequest $request)
    {
        return User::create($request->all()); //Работает
    }

    public function logout()
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
