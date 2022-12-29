<?php

namespace App\Http\Controllers;

use App\Models\Tokens;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTFactory;
use PHPOpenSourceSaver\JWTAuth\Token;

class TokenController extends Controller
{
    public static function token()
    {
        return static::store();
    }
    static function store()
    {
        $customClaims = ["iat" => now(), "exp" => now()->addMinutes(config("TOKEN_EXPIRE", 40)), "sub" => now()];
        $factory = JWTFactory::customClaims($customClaims);
        $payload = $factory->make();
        $token = JWTAuth::encode($payload);
        Tokens::create([
            "token" => $token
        ]);
        return MainController::responseMessages(["success" => true, "token" => "$token"], 200);
    }
    static function decodeToken($token)
    {
        try{
            return $decoded = JWTAuth::decode(new Token($token));
        }
        catch (TokenInvalidException|TokenExpiredException $e)
        {
            return false;
        }
    }
    static function isValidToken($decodedToken)
    {
        $exp = Carbon::createFromTimestamp($decodedToken["exp"]);
        return now() < $exp;
    }
    static function checkTokenModel($token)
    {
        $TokenModel = Tokens::where("token", $token)->first();
        if ($TokenModel === null) return false;
        else
        {
            $TokenModel->delete();
            return true;
        }
    }
    static function validateToken($token)
    {
        if (!static::checkTokenModel($token)) return false;
        return static::isValidToken(static::decodeToken($token));
    }
}
