<?php

namespace App\Http\Middleware;

use App\Enum\SettingStatus;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Ensure the admin guard is set for this request
            config(['auth.defaults.guard' => 'admin']);
            
            // Authenticate the user via the token
            $user = JWTAuth::parseToken()->authenticate();

            // Get token and payload
            $token = JWTAuth::getToken();
            $payload = JWTAuth::getPayload($token)->toArray();

            // Ensure that the user is an admin
            if ($payload['type'] !== 'admin') {
                return response()->json([
                    'status' => false,
                    'message' => 'Not authorized',
                ], 403); // Use 403 Forbidden status
            }

            // Check if the user's status is disabled
            if ($user->status == SettingStatus::getDisabled()) {
                return response()->json([
                    'status' => false,
                    'message' => __('site.Contact with Adminstration Your are Block'),
                ], 403); // Use 403 Forbidden status
            }

        } catch (Exception $e) {
            // Handle different exceptions from JWT
            if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token is Invalid',
                ], 401); // Use 401 Unauthorized status
            } else if ($e instanceof TokenExpiredException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token is Expired',
                ], 401); // Use 401 Unauthorized status
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Authorization Token not found',
                ], 401); // Use 401 Unauthorized status
            }
        }

        return $next($request); // Proceed to the next middleware or controller
    }
}
