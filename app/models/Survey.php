<?php
namespace App\Models;

use Core\{Model, Database};

final class Survey extends Model
{
    public const DEACTIVE = 0;
    public const ACTIVE = 1;

    public static function all(int $userId)
    {
        return Database::get()->from("surveys")->where("userId", "=", $userId)->results();
    }

    public static function exists(string $column, string $value)
    {
        return Database::get()->from("surveys")->where($column, "=", $value)->result();
    }
}
