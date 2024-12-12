<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Repositories\Client\ClientRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Services\ImageService;


class ClientAuthController extends Controller
{
    protected $clientRepo;

    public function __construct(ClientRepositoryInterface $clientRepo)
    {
        $this->clientRepo = $clientRepo;
    }

     // Client Registration
     public function register(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'phone' => 'required|unique:clients,phone',
             'password' => 'required|min:6|max:255',
             'username' => 'required|unique:clients|max:255',
             'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate photo
             'company_name' => 'nullable|string|max:255',
             'website' => 'nullable|url|max:255',
             'address' => 'nullable|string|max:255',
             'city' => 'nullable|string|max:255',
             'country' => 'nullable|string|max:255',
         ]);
     
         if ($validator->fails()) {
             return response()->json([
                 "status" => false,
                 'code' => 402,
                 'message' => $validator->errors()->first(),
                 'data' => null,
             ], 402);
         }
     
         // Use ImageService to handle file upload
         $photoPath = $request->hasFile('photo') 
             ? ImageService::upload($request->file('photo'), 'client_photos')
             : null;
     
         // Create the client record
         $client = Client::create([
             "username" => $request->username,
             "phone" => $request->phone,
             "password" => Hash::make($request->password),
             'name' => $request->name,
             'email' => $request->email,
             'photo' => $photoPath, // Save the photo path in the database
             'company_name' => $request->company_name,
             'website' => $request->website,
             'address' => $request->address,
             'city' => $request->city,
             'country' => $request->country,
         ]);
     
         return response()->json([
             'status' => true,
             'code' => 200,
             'message' => "Client account created successfully",
             'data' => [
                 'id' => $client->id,
                 'username' => $client->username,
                 'phone' => $client->phone,
                 'email' => $client->email,
                 'name' => $client->name,
                 'photo' => $photoPath ? asset($photoPath) : null, // Use ImageService result
                 'company_name' => $client->company_name,
                 'website' => $client->website,
                 'address' => $client->address,
                 'city' => $client->city,
                 'country' => $client->country,
             ],
         ], 200);
     }
     



     public function login(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'login' => 'required', // 'login' can be either phone or username
             'password' => 'required',
         ]);
     
         if ($validator->fails()) {
             return response()->json([
                 "status" => false,
                 'code' => 402,
                 'message' => $validator->errors()->first(),
                 'data' => null,
             ], 402);
         }
     
         // Check if the login is a phone number or username
         $client = Client::where('phone', $request->login) // Check if it's a phone number
                        ->orWhere('username', $request->login) // Or if it's a username
                        ->first();
     
         if ($client) {
             // Set credentials for phone or username
             $credentials = [
                 'password' => $request->password,
             ];
     
             if ($client->phone == $request->login) {
                 // If login is phone, pass phone with password to JWTAuth attempt
                 $credentials['phone'] = $request->login;
             } else {
                 // If login is username, pass username with password to JWTAuth attempt
                 $credentials['username'] = $request->login;
             }
     
             try {
                 // Authenticate the client with the client guard
                 if (!$token = auth('client')->attempt($credentials)) { 
                     return response()->json([
                         'status' => false,
                         'code' => 401,
                         'message' => __('The phone/username or password is incorrect'),
                         'data' => null,
                     ], 401);
                 }
             } catch (JWTException $e) {
                 return response()->json([
                     'status' => false,
                     'code' => 500,
                     'message' => __('Server error, please try again later'),
                     'data' => null,
                 ], 500);
             }
     
             // If successful, return the client's data and token
             $data = $client->toArray();  // Convert client model to array
             $data['token'] = $token; // Assign the generated token to the data array
             $data['type'] = 'client';
     
             return response()->json([
                 'status' => true,
                 'code' => 200,
                 'message' => __('Login successful'),
                 'data' => $data,
             ], 200);
         }
     
         return response()->json([
             'status' => false,
             'message' => __('The phone/username does not exist'),
         ], 404);
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
