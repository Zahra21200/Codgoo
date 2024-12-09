<?php

namespace App\Repositories\Admin;

interface AdminRepositoryInterface
{
    public function register(array $data);
    public function login(array $credentials);
    public function logout();
    public function forgotPassword($phone);
}