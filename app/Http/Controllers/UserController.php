<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMainRequest;
use App\Http\Requests\ValidateStoreUserRequest;
use App\Http\Requests\ValidateUsersRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function usersStore(Request $request, StoreMainRequest $storeMainRequest)
    {
        $token = $request->header("Token");
        if (!TokenController::validateToken($token))
            return MainController::responseMessages(["success" => false, "message" => "The token expired."], 401);
        $data = $storeMainRequest->validated();
        if (User::checkIfExists($data["email"], $data["phone"]))
            return MainController::responseMessages(["success" => false, "message" => "User with this phone or email already exist"], 409);
        return MainController::responseMessages(["success" => true, "user_id" => User::userStore($request, $data)->id, "message" => "User successfully registered."], 200);
    }
    public function users(ValidateUsersRequest $request)
    {
        return User::usersList($request, $request->validated());
    }
    public function usersShow(Request $request, $userID)
    {
        return User::userShowCheckForFailOrGive(User::userShowValidation($userID), $userID);
    }
    public function userStore(ValidateStoreUserRequest $request)
    {
        User::userStore($request, $request->validated());
        return to_route("home");
    }
}
