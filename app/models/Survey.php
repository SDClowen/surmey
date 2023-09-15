<?php
namespace App\Models;

use Core\{Model, Database};

final class Survey extends Model
{
    public const DEACTIVE = 0;
    public const ACTIVE = 1;

    public static function all(int $userId)
    {
        /*return Database::get()->select("count(answers.id) answersCount, surveys.*")
                ->from("surveys")
                ->leftJoin("answers", "answers.surveyId = surveys.id")
                ->where("surveys.userId", "=", $userId)
                ->results();*/

        return Database::get()->query("
                select (
                    select count(answers.id) from answers where answers.surveyId = surveys.id
                ) answersCount, 
                surveys.*
                from surveys
                where surveys.userId = ?"
            )->results(params: [$userId]);
    }

    public static function exists(string $column, string $value)
    {
        return Database::get()->from("surveys")->where($column, "=", $value)->result();
    }

    public static function existsByUserId(int $userId, string $column, string $value)
    {
        return Database::get()->from("surveys")->where("userId", "=", $userId)->where($column, "=", $value)->result();
    }

    public static function update(string $surveyId, array $data)
    {
        return Database::get()->from("surveys")->where("id", "=", $surveyId)->update($data);
    }

    public static function count(int $userId)
    {
        return Database::get()->select("count(id)")->from("surveys")->where("userId", "=", $userId)->first();
    }
    
    public static function participateCount(int $userId)
    {
        return Database::get()->select("count(surveys.id)")
            ->from("surveys")
            ->leftJoin("answers", "answers.surveyId = surveys.id")
            ->where("surveys.userId", "=", $userId)
            ->first();
    }
}
