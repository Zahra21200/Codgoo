<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


use App\Repositories\Client\ClientRepositoryInterface;


class ClientAuthController extends Controller
{
    protected $clientRepo;

    public function __construct(ClientRepositoryInterface $clientRepo)
    {
        $this->clientRepo = $clientRepo;
    }

    public function register(Request $request)
    {
        $data = $request->only([
            'username', 'name', 'email', 'phone', 'password', 'photo',
            'company_name', 'website', 'address', 'city', 'country'
        ]);
        $result = $this->clientRepo->register($data);

        return response()->json($result, 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);
        $result = $this->clientRepo->login($credentials);

        return response()->json($result);
    }

    public function logout()
    {
        $result = $this->clientRepo->logout();
        return response()->json($result);
    }

    public function forgotPassword(Request $request)
    {
        $result = $this->clientRepo->forgotPassword($request->phone);
        return response()->json($result);
    }
}
