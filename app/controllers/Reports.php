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
            
            echo "<b>".$value->title."</b><br>";
            echo "***************************************";
            
            foreach ($value->answers as $k => $answer) {

                $count = 0;
                $search = function($slug) use ($count, $answerData){
                    array_walk($answerData, function($aw_V, $aw_K) use ($count, $slug){

                        $decodedJson = json_decode($aw_V->data, JSON_OBJECT_AS_ARRAY);

                        $hasValue = array_key_exists($slug, $decodedJson);
                        if($hasValue)
                            $count++;

                        #echo print_r($decodedJson, true)."<br>";

                    });
                };
                
                $slug = ($value->type == "checkbox" ? $value->slug.$k : $value->slug);

                $search($slug);

                echo "<br><i>$k [ $slug ]-$answer (<b>$count</b>)</i>";
            }

            echo "<hr>";
        }
    }

    #[route(method: route::get | route::xhr_get, session: "user", otherwise: "/auth")]
    public function watch(int $surveyId)
    {
        $survey = Survey::existsByUserId(User::id(), "id", $surveyId);
        if (!$survey)
            redirect();

        $questionData = json_decode($survey->data);
        $answerData = $this->db->select("answers.*, personals.fullname, personals.department")
            ->from("answers")
            ->join("personals", "personals.id = answers.personalId")
            ->where("surveyId", "=", $surveyId)
            ->results();

        $generatedData = [];

        $groupIndex = 0;
        #for IK
        if ($survey->id == 1)
            $groups = ["Yönetici-Çalışan İlişkileri", "İletişim", "Göreve İlişkin Sorular", "Çalışma Koşulları", "Eğitim /Gelişim", "Kariyer", "Ücret Sosyal Yardımlar ve Ödüllendirme", "Genel Algı"];
        else
            $groups = ["default"];

        $isFirstDescription = true;
        $data = [];
        
        $willGenerateDummyData = false; 
        if($willGenerateDummyData) # not working
        {
             # TODO: generate dummy answer data
            foreach($questionData as $question)
            {
                if($question->type == "radio" || 
                    $question->type == "checkbox")
                {
                    foreach($question->answers as $key => $answers)
                    {
                        $data[$question->type == "radio" ? $question->slug : $question->slug.$key] = 0;
                    }

                    continue;
                }

                $data[$question->slug] = 0;
            }
        }

        /*array_unshift($answerData, (object)[     
            "id" =>  0,
            "surveyId" =>  0,
            "personalId" =>  0,
            "data" => json_encode($data),
            "token" =>  0,
            "tokenTime" =>  0,
            "done" =>  0,
            "updated_at" =>  "2023-09-14 00:00",
            "created_at" =>  "2023-09-14 00:00",
            "fullname" =>  "dummy",
            "department" =>  "dummy"
        ]);*/

        #unset($answerData[0]);

        foreach ($questionData as $question) {
            if ($question->type == "description") {
                if ($isFirstDescription)
                    $isFirstDescription = false;
                else
                    $groupIndex++;

                continue;
            }

            $group0 = $groups[$groupIndex];

            $filterResults = array_filter($answerData, function ($v, $k) use ($question) {
                $decodedJson = json_decode($v->data, true);
                if ($decodedJson == null)
                    return false;

                if ($question->type == "checkbox") {
                    foreach ($question->answers as $answerKey => $answerValue) 
                        if (array_key_exists($question->slug . $answerKey, $decodedJson)) 
                            return true;
                }
                else 
                    return array_key_exists($question->slug, $decodedJson); 
                
                return false;
            }, ARRAY_FILTER_USE_BOTH); 
            
            foreach ($filterResults as $fValue) {
                $decodedJson = json_decode($fValue->data, true);

                try {

                    if ($question->type == "checkbox") {
                        foreach ($question->answers as $akey => $avalue) {

                            if(!isset($decodedJson[$question->slug.$akey]))
                                continue;
                            
                            $answerValue = $decodedJson[$question->slug.$akey];

                            $answerTitle = $question->answers[$answerValue];

                            #foreach ($value->answers as $answer)
                            #$generatedData[$group0][$value->slug][$answer] = [];

                            $generatedData[$group0][$question->type . "::" . $question->title][$answerTitle][] = (object) [
                                "id" => $fValue->personalId,
                                "fullname" => $fValue->fullname,
                                "department" => $fValue->department,
                                #"answer" => $answerTitle,
                                "value" => $answerValue
                            ];
                        }

                        continue;
                    }

                    $answerValue = $decodedJson[$question->slug];

                    if ($question->type == "textarea") {
                        $generatedData[$group0][$question->type . "::" . $question->title][] = (object) [
                            "id" => $fValue->personalId,
                            "fullname" => $fValue->fullname,
                            "department" => $fValue->department,
                            #"answer" => $answerTitle,
                            "value" => $answerValue
                        ];

                        continue;
                    }
                    
                    $answerTitle = $question->answers[$answerValue];

                    #foreach ($value->answers as $answer)
                    #$generatedData[$group0][$value->slug][$answer] = [];

                    $generatedData[$group0][$question->type . "::" . $question->title][$answerTitle][] = (object) [
                        "id" => $fValue->personalId,
                        "fullname" => $fValue->fullname,
                        "department" => $fValue->department,
                        #"answer" => $answerTitle,
                        "value" => $answerValue
                    ];
                } catch (\Throwable $th) {
                    throw $th;
                }
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

            if ($type === "radio" || $type === "checkbox") {

                foreach ($question as $answerK => $answerV)
                    $result[$title]["answers"][$answerK] = count($answerV);

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
                    "Boş" => $emptyCount,
                ];

                $result[$title]["list-json"] = data_json($result[$title]["list-json"]);
            }
        }

        $this->view("main", "reports", lang("reports"), [
            "user" => User::info(),
            "data" => $result
        ]);
    }

    #[route(uri: "download-csv")]
    public function downloadCsv(int $surveyId)
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

        $survey->questions = json_decode($survey->data);
        $headers = [];
        foreach ($survey->questions as $question) {
            if($question->type == "description")
                continue;

            $headers[] = $question->title; #iconv('UTF-8', 'WINDOWS-1254', $question->title);
        }

        fputcsv($fp, $headers);

        $survey->responses = $this->db->select("answers.*, personals.fullname, personals.department")
                        ->from("answers")
                        ->join("personals", "personals.id = answers.personalId")
                        ->where("surveyId", "=", $surveyId)
                        ->results();
                        
        /*foreach ($survey->responses as $response) {
            $row = [];
            foreach ($survey->questions as $question) {
                $data = json_decode($response->data);
                
                foreach ($data as $key => $value) {
                    $row[] = $value;
                }
            }
            fputcsv($fp, $row);
        }*/

        fclose($fp);
        exit;
    }
}