<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user = new UserResource($user);
        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);

        if ($user && $token) {
            $resToken = $this->respondWithToken($token);
            return response()->json(["user" => $user, "token" => $resToken, 'status' => 'success'], 200);
        }
        return response()->json([$user, 'status' => 'faild'], 500);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => "you successfully logout"]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 24 * 365 * 10,
            'user' =>new UserResource(auth()->user()) ,
        ]);
    }

}
