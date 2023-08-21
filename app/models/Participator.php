<?php
namespace App\Models;

use Core\{Model, Database};

final class Participator extends Model
{
    /**
     * Get user info from the session
     */
    public static function info()
    {
        $user = session_get("participator");

        return $user;
    }

    public static function checkSurveyIsParticipated(int $surveyId, int $personalId, bool $isDone = false) : int
    {
        return Database::get()->select("count(id)")
            ->from("answers")
            ->where("surveyId", "=", $surveyId)
            ->where("personalId", "=", $personalId)
            ->where("done", "=", $isDone)
            ->first();
    }

    public static function answerExists(int $surveyId, int $personalId, bool $isDone = false) : int
    {
        return Database::get()->select("id")
            ->from("answers")
            ->where("surveyId", "=", $surveyId)
            ->where("personalId", "=", $personalId)
            ->where("done", "=", $isDone)
            ->first();
    }

    public static function checkToken($pin)
    {
        return Database::get()->from("answers")
            ->where("token", "=", $pin)
            ->result();
    }
}