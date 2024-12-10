<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use App\Repositories\Admin\AdminRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements AdminRepositoryInterface
{
    public function register(array $data)
    {
        $admin = Admin::create([
            'username' => $data['username'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        $token = JWTAuth::fromUser($admin);

        return [
            'admin' => $admin,
            'token' => $token,
        ];
    }

    public function login(array $credentials)
    {
        if ($token = JWTAuth::attempt($credentials)) {
            return ['token' => $token];
        }

        return ['error' => 'Unauthorized'];
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return ['message' => 'Successfully logged out'];
    }

    public function forgotPassword($phone)
    {
        $admin = Admin::where('phone', $phone)->first();
        if (!$admin) {
            return ['error' => 'Admin not found'];
        }

        // Implement your password reset logic here (e.g., sending reset email or SMS)
        return ['message' => 'Password reset link sent'];
    }
}
