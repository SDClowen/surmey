<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Survey;
use Core\{Controller, Request};
use Core\Attributes\route;

class Reports extends Controller
{
    #[route(method: route::get | route::xhr_get)]
    public function watch(int $surveyId)
    {
        $survey = Survey::exists("id", $surveyId);
        if (! $survey)
            redirect();

        $jsonData = json_decode($survey->data);
        $answerData = $this->db->select("answers.*, personals.fullname, personals.department")
            ->from("answers")
            ->join("personals", "personals.id = answers.personalId")
            ->where("surveyId", "=", $surveyId)
            ->results();

        $generatedData = [];

        foreach ($jsonData as $value) {
            if ($value->type == "description")
                continue;

            $filterResults = array_filter($answerData, function ($v, $k) use ($value) {
                $decodedJson = json_decode($v->data, true);

                return array_key_exists($value->slug, $decodedJson);
            }, ARRAY_FILTER_USE_BOTH);

            foreach ($filterResults as $fValue) {
                $decodedJson = json_decode($fValue->data, true);

                $answerValue = $decodedJson[$value->slug];
                $answerTitle = $value->answers[$decodedJson[$value->slug]];

                $group0 = "Yönetici Çalışan İlişkileri";

                foreach ($value->answers as $answer)
                    $generatedData[$group0][$value->slug][$answer] = [];

                $generatedData[$group0][$value->slug][$answerTitle][] = [
                    "id" => $fValue->personalId,
                    "fullname" => $fValue->fullname,
                    "department" => $fValue->department
                ];
            }
        }


        $this->view("main", "reports", lang("reports"), [
            "user" => User::info(),
            "generatedData" => $generatedData,
            "generatedDataJ" => json_encode($generatedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        ]);
    }
}