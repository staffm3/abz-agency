<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMainRequest;
use App\Http\Requests\ValidateUsersRequest;
use App\Models\Position;
use App\Models\Tokens;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTFactory;
use PHPOpenSourceSaver\JWTAuth\Token;

class MainController extends Controller
{
    public static function responseMessages($array, $status)
    {
        return response()->json($array, $status);
    }
    public function home()
    {
        return view("home");
    }
    public function users()
    {
        return view("users");
    }
    public function positions()
    {
        return view("positions");
    }
    public function userCreate()
    {
        $positions = Position::orderBy("id")->get()->makeVisible(["id"]);
        return view("create", compact("positions"));
    }
}
