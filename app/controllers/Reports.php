<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Survey;
use Core\{Controller, Request};
use Core\Attributes\route;

class Reports extends Controller
{
    #[route(method: route::get | route::xhr_get, session: "user", otherwise: "/auth")]
    public function watch2(int $surveyId)
    {
        #$survey = Survey::existsByUserId(User::id(), "id", $surveyId);
        $survey = Survey::exists("id", $surveyId);
        if (!$survey)
            redirect();

        $answerData = $this->db->select("answers.*, personals.fullname, personals.department")
            ->from("answers")
            ->join("personals", "personals.id = answers.personalId")
            ->where("surveyId", "=", $surveyId)
            ->results();

        /*echo "<pre>";
        print_r($answerData);*/

        $questionData = json_decode($survey->data);

        foreach ($questionData as $key => $value) {

            if($value->type == "description")
                continue;

            $search = function($k) use ($value, $answerData){
                return array_filter($answerData, function($aw_V, $aw_K) use ($value, $k){

                    $decodedJson = json_decode($aw_V->data, JSON_OBJECT_AS_ARRAY);
                    if(!$decodedJson)
                        return;

                    $s = $value->type == "checkbox" ? $value->slug.$k : $value->slug;

                    $exists = array_key_exists($s, $decodedJson); 
                    if($exists && $value->type == "radio")
                        return $decodedJson[$s] == $k;

                    return $exists;

                }, ARRAY_FILTER_USE_BOTH);
            };
            
            echo "<b>".$value->title."</b><br>";
            echo "***************************************";
            
            foreach ($value->answers as $k => $answer) {

                $filtered = $search($k);
                    
                $slug = ($value->type == "checkbox" ? $value->slug.$k : $value->slug);

                $count = count($filtered);
                echo "<br><i>$k [ $slug ] - $answer (<b>$count</b>)</i>";
            }

            if($value->type == "textarea")
            {
                $data = $search(0);
                foreach($data as $v)
                {
                    $d = json_decode($v->data, JSON_OBJECT_AS_ARRAY)[$value->slug];
                    if(empty($d))
                        continue;
                    
                    echo $d."<br>";
                }
            }

            echo "<hr>";
        }
    }

    #[route(method: route::get | route::xhr_get, session: "user", otherwise: "/auth")]
    public function watch(int $surveyId)
    {
        #$survey = Survey::existsByUserId(User::id(), "id", $surveyId);
        $survey = Survey::exists("id", $surveyId);
        if (!$survey)
            redirect();

        $result = Survey::report($survey);

        $this->view("main", "reports", lang("reports"), [
            "user" => User::info(),
            "data" => $result,
            "surveyId" => $surveyId
        ]);
    }

    #[route(uri: "csv", method: route::xhr_get)]
    public function csv(int $surveyId)
    {
        $survey = Survey::existsByUserId(User::id(), "id", $surveyId);
        if(!$survey)
            redirect();

        header('Pragma: private');
        header('Cache-control: private, must-revalidate');
        header('Content-type: text/csv');
        $csvFileName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $survey->title));
        header('Content-Disposition: attachment; filename=' . $csvFileName . '.csv');

        $fp = fopen('php://output', 'w');

        $report = Survey::report($survey);
        $data = [];

        foreach($report as $title => $data)
        {
            $csvData[] = $title;

            foreach($data["answers"] as $answerKey => $answerValue)
            {
                $csvData[] = $answerKey.":".$answerValue;
            }

            $data = $csvData;
        }
        fputcsv($fp, $data);

        fclose($fp);
        exit;
    }
}