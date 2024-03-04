<?php
namespace App\Models;

use Core\{Model, Database};

final class Survey extends Model
{
    public const ALL = 0;
    public const ACTIVE = 1;
    public const PASSIVE = 2;

    public static function all(int $userId, $status = self::ACTIVE)
    {
        /*return Database::get()->select("count(answers.id) answersCount, surveys.*")
                ->from("surveys")
                ->leftJoin("answers", "answers.surveyId = surveys.id")
                ->where("surveys.userId", "=", $userId)
                ->results();*/

        $query = "
            select (
                select count(answers.id) from answers where answers.surveyId = surveys.id
            ) answersCount, 
            surveys.*
            from surveys
            where surveys.userId = ?" . ($status != self::ALL ? " and surveys.status = ?" : "");

        $params = [$userId];
        if ($status != 0)
            array_push($params, $status);

        return Database::get()->query($query)->results(params: $params);
    }

    public static function exists(string $column, string $value)
    {
        return Database::get()->from("surveys")->where($column, "=", $value)->result();
    }

    public static function reset(int $surveyId)
    {
        return Database::get()->from("answers")->where("surveyId", value: $surveyId)->delete();
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
        return Database::get()->select("count(id)")->from("surveys")->where("userId", "=", $userId)->where("status", "=", 1)->first();
    }

    public static function participators(int $surveyId)
    {
        return Database::get()
            ->from("answers")
            ->join("personals", "personals.id = answers.personalId")
            ->where("answers.surveyId", value:$surveyId)
            ->where("answers.done", value: 1)
            ->results();
    }

    public static function participateCount(int $userId)
    {
        return Database::get()->select("count(answers.id)")
            ->from("answers")
            ->join("surveys", "surveys.id = answers.surveyId")
            ->where("surveys.userId", "=", $userId)
            ->first();
    }

    public static function report($survey)
    {
        $questionData = json_decode($survey->data);
        $answerData = Database::get()
            ->select("answers.*, personals.fullname, personals.department")
            ->from("answers")
            ->join("personals", "personals.id = answers.personalId")
            ->where("surveyId", "=", $survey->id)
            ->results();

        $generatedData = [];

        $groupIndex = 0;
        #for IK
        if ($survey->id == 1)
            $groups = ["Yönetici-Çalışan İlişkileri", "İletişim", "Göreve İlişkin Sorular", "Çalışma Koşulları", "Eğitim /Gelişim", "Kariyer", "Ücret Sosyal Yardımlar ve Ödüllendirme", "Genel Algı"];
        else
            $groups = ["default"];

        $isFirstDescription = true;

        foreach ($questionData as $question) {
            if ($question->type == "description") {
                if ($isFirstDescription)
                    $isFirstDescription = false;
                else
                    $groupIndex++;

                continue;
            }

            $group0 = $groups[$groupIndex];
            $search = function ($k) use ($question, $answerData) {
                return array_filter($answerData, function ($aw_V, $aw_K) use ($question, $k) {
                    if(!$aw_V || !$aw_V->data)
                        return;

                    $decodedJson = json_decode($aw_V->data, JSON_OBJECT_AS_ARRAY);
                    if (! $decodedJson)
                        return;

                    $s = $question->type == "checkbox" ? $question->slug . $k : $question->slug;

                    $exists = array_key_exists($s, $decodedJson);
                    if ($exists && $question->type == "radio")
                        return $decodedJson[$s] == $k;

                    return $exists;

                }, ARRAY_FILTER_USE_BOTH);
            };

            foreach ($question->answers as $answerKey => $answer) {
                $filtered = $search($answerKey);
                if (! count($filtered))
                    $generatedData[$group0][$question->type . "::" . $question->title][$answer] = [];

                foreach ($filtered as $fValue) {
                    $slug = ($question->type == "checkbox" ? $question->slug . $answerKey : $question->slug);

                    $decodedJson = json_decode($fValue->data, JSON_OBJECT_AS_ARRAY);

                    if (! isset($decodedJson[$slug]))
                        continue;

                    $answerValue = $decodedJson[$slug];

                    #foreach ($value->answers as $answer)
                    #$generatedData[$group0][$value->slug][$answer] = [];

                    $generatedData[$group0][$question->type . "::" . $question->title][$answer][] = (object) [
                        "id" => $fValue->personalId,
                        "fullname" => $fValue->fullname,
                        "department" => $fValue->department,
                        #"answer" => $answer,
                        "value" => $answerValue
                    ];

                    $answerTitle = $question->answers[$answerValue];
                }
            }

            if ($question->type != "textarea")
                continue;

            $data = $search(0);

            foreach ($data as $answer) {
                $answerValue = json_decode($answer->data, JSON_OBJECT_AS_ARRAY)[$question->slug];
                $generatedData[$group0][$question->type . "::" . $question->title][] = (object) [
                    "id" => $answer->personalId,
                    "fullname" => $answer->fullname,
                    "department" => $answer->department,
                    #"answer" => $answerTitle,
                    "value" => $answerValue
                ];

            }
        }

        $result = [];

        $group0Data = current($generatedData);
        if (! $group0Data)
            $group0Data = [];

        foreach ($group0Data as $key => $question) {
            $split = explode("::", $key);

            $type = $split[0];
            $title = $split[1];

            $result[$title] = [
                "type" => $type
            ];

            $result[$title]["list-json"] = [];

            $totalCount = 0;
            if ($type === "radio" || $type === "checkbox") {

                foreach ($question as $answerK => $answerV) {
                    $count = count($answerV);
                    $result[$title]["answers"][$answerK] = $count;
                    $totalCount += $count;
                }

                $result[$title]["total"] = $totalCount;

            } else {
                $emptyCount = $fillCount = 0;
                foreach ($question as $answerK => $answerV) {
                    if (empty($answerV->value))
                        $emptyCount++;
                    else {
                        $fillCount++;
                        $result[$title]["list-json"][] = $answerV;
                    }

                }

                $result[$title]["answers"] = [
                    "Dolu" => $fillCount,
                    "Boş" => $emptyCount
                ];

                $totalCount = $fillCount + $emptyCount;

                $result[$title]["list-json"] = data_json($result[$title]["list-json"]);
            }

            $result[$title]["total"] = $totalCount;

        }

        return $result;
    }
}
