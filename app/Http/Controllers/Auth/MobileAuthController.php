<?php 

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTFactory;

class MobileAuthController extends Controller
{	
	// Creates the token for the user to access
	// information.
    public function create_token(Request $request) {
        $user = json_decode($request->user);
        $user['sub'] = env('API_ID');

        $payload = JWTFactory::make((array) $user);

        $token = JWTAuth::encode($payload);

        return $token;
    }

    // When users log out it will blacklist their token,
    // so they can not access information if they are logged out.
    public function black_list_token(Request $request) {
        try {
            JWTAuth::invalidate($request->input('token'));
            return 'true';
        } catch (JWTException $e) {
            return 'false';
        }
    }
}    