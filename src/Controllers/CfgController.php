<?php

namespace ptrml\polynotice\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Tymon\JWTAuth\JWTAuth;
use Carbon\Carbon;

class CfgController extends Controller
{
    protected $JWTAuth;
    protected $auth;

    public function __construct(JWTAuth $JWTAuth, Guard $auth)
    {
        $this->JWTAuth = $JWTAuth;
        $this->auth = $auth;
    }

    public function index()
    {
        $user = $this->auth->user();
        $tokenId = base64_encode(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        $issuedAt = Carbon::now()->timestamp;
        $notBefore = $issuedAt;             //Adding 10 seconds
        $expire = $notBefore + 6 * 60 * 60;            // Adding 6 hours
        /*
        * Create the token as an array
        */
        $data = [
            'iat' => $issuedAt,      // Issued at: time when the token was generated
            'jti' => $tokenId,   // Json Token Id: an unique identifier for the token
            'iss' => 'https://example.com',       // Issuer
            'nbf' => $notBefore,        // Not before
            'exp' => $expire,           // Expire
            'data' => [                  // Data related to the signed user
                'userId' => \Auth::id(), // userid from the users table
            ]
        ];
        $response = [
            'jwt' => $this->JWTAuth->fromUser($user, $data),
            'node_url' => 'http://192.168.100.8:6001', //better to move this to .env file
        ];
        return response()->json($response);
    }
}