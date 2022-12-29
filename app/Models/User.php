<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\MainController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Tinify\AccountException;
use Tinify\ClientException;
use Tinify\ConnectionException;
use Tinify\Exception;
use Tinify\ServerException;
use Tinify\Tinify;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        "phone",
        "position_id",
        "photo",
        "position"
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public $timestamps = false;
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function uploadPhoto($request, $data)
    {
        $file = $request->file('photo');
        $filename = now()->timestamp."_".$file->getClientOriginalName();
        $file->storeAs("public/images", $filename);
        try {
            $source = \Tinify\fromFile(public_path("storage".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."$filename"));
            $resized = $source->resize(array(
                "method" => "cover",
                "width" => 70,
                "height" => 70
            ));
            $resized->toFile(public_path("storage".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."$filename"));
            $this->update([
                "photo" => asset("storage/images/$filename")
            ]);
        } catch(AccountException|ClientException|ServerException|ConnectionException|Exception $e) {
            $this->update([
                "photo" => asset("storage/images/$filename")
            ]);
        }
    }
    public static function checkIfExists($email, $phone)
    {
        return static::where("email", $email)->orWhere("phone", $phone)->exists();
    }
    static function userStore($request, $data)
    {
        $currentPosition = Position::find($data["position_id"])->first();
        $data["photo"] = "123";
        $data["position"] = $currentPosition->name;
        $user = static::create($data);
        $user->uploadPhoto($request, $data);
        return $user;
    }
    static function usersList($request, $data): \Illuminate\Http\JsonResponse
    {
        $data["page"] = $data["page"] ?? 1;
        $data["offset"] = $data["offset"] ?? 0;
        $data["count"] = $data["count"] ?? 5;
        $users = User::paginate($data["count"])->appends($request->input())->toArray();
        if (count($users["data"]) === 0) return MainController::responseMessages(["success" => false, "message" => "Users not found"], 404);
        return MainController::responseMessages([
            "success" => true,
            "total_pages" => $users["last_page"],
            "total_users" => $users["total"],
            "count" => $users["per_page"],
            "page" => $users["current_page"],
            "links" => ["next_url" => $users["next_page_url"], "prev_url" => $users["prev_page_url"]],
            "users" => $users["data"]
        ], 200);
    }
    static function userShowValidation($userID): \Illuminate\Validation\Validator
    {
         return Validator::make(["user_id" => $userID], ["user_id" => "required|numeric|exists:\App\Models\User,id"], $messages = [
            'exists' => 'User not found',
            'numeric' => 'The user_id must be an integer.'
        ]);
    }
    static function userShowCheckForFailOrGive($data, $userID)
    {
        if ($data->fails())
        {
            $userNotFound = $data->errors()->toArray()["user_id"][0] == "User not found";
            return MainController::responseMessages([
                "success" => false,
                "message" => $userNotFound ? "The user with the requested identifier does not exist" : "Validation failed",
                "fails" => [
                    $data->errors()->toJson()
                ]
            ], $userNotFound ? 404 : 400);
        }else{
            $user = User::find($userID);
            return MainController::responseMessages(["success" => true, "user" => $user], 200);
        }
    }
}
