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
        $answerData = $this->db->from("answers")->where("surveyId", "=", $surveyId)->results();
        print_r($answerData);

        foreach($jsonData as $value)
        {
            if($value->type == "description")
                continue;

        }

        /*$this->view("main", "reports", lang("reports"), [
            "user" => User::info(),
            "data" => print_r(json_decode($survey->data), true)
        ]);*/
    }
}