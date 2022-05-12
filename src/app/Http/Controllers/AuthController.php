<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request): AuthResource
    {
        $user = User::query()->where('login', $request->post('login'))->first();

        if (! $user || ! Hash::check($request->post('password'), $user->password)) {
            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        return new AuthResource($user);
    }

    public function register(RegisterRequest $request): AuthResource
    {
        $user = User::query()->create([
            'name' => $request->post('name'),
            'login' => $request->post('login'),
            'password' => Hash::make($request->post('password'))
        ]);

        return new AuthResource($user);
    }

    public function logout(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
