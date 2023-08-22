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
        if(!$survey)
            redirect();

        $jsonData = json_decode($survey->data);
        $answerData = $this->db->select("answers.*, personals.fullname, personals.department")
            ->from("answers")
            ->join("personals", "personals.id = answers.personalId")
            ->where("surveyId", "=", $surveyId)
            ->results();

        $generalStatistics = [];
        $departmentStatistics = [];

        foreach($jsonData as $value)
        {
            if($value->type == "description")
                continue;

            foreach($value->answers as $key => $answer)
            {
                $value->answers[$key] = [
                    "title" => $answer,
                    "departments" => []
                ];
            }

            $filterResults = array_filter($answerData, function($v, $k) use ($value) {
                $decodedJson = json_decode($v->data, true);
                
                return array_key_exists($value->slug, $decodedJson);
            }, ARRAY_FILTER_USE_BOTH);

            #if(count($filterResults) == 0)
                #continue;

            foreach($filterResults as $fValue){
                $decodedJson = json_decode($fValue->data, true);
    
                $generalStatistics[$value->slug][] = [
                    "personal" => [
                        "id" => $fValue->personalId,
                        "fullname" => $fValue->fullname,
                        "department" => $fValue->department
                    ],
                    "value" => $decodedJson[$value->slug],
                    "title" => $value->answers[$decodedJson[$value->slug]]
                ];
            }
        }

        $this->view("main", "reports", lang("reports"), [
            "user" => User::info(),
            "generalStatistics" => $generalStatistics,
            "generalStatisticsj" => json_encode($generalStatistics, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
        ]);
    }
}