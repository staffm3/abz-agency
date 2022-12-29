<?php

namespace App\Models;

use App\Http\Controllers\MainController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $hidden = [
      "id"
    ];
    static function getPositionsOrDie(): \Illuminate\Http\JsonResponse
    {
        $positions = static::orderBy("id")->get()->makeVisible(["id"]);
        return (!$positions->count())
            ? MainController::responseMessages(["success" => false, "message" => "Positions not found"], 422)
            : MainController::responseMessages(["success" => true, "positions" => $positions], 200);
    }
}
