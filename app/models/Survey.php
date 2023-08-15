<?php
namespace App\Models;

use Core\{Model, Database};

final class Survey extends Model
{
    public static function all(int $userId)
    {
        return Database::get()->from("surveys")->where("userId", "=", $userId)->results();
    }
}
