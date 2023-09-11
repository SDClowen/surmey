<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Survey;
use Core\{Controller, Request};
use Core\Attributes\route;

class Reports extends Controller
{
    #[route(method: route::get | route::xhr_get, session: "user", otherwise: "/auth")]
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

        $groupIndex = 0;
        #for IK
        if ($survey->id == 1)
            $groups = ["Yönetici-Çalışan İlişkileri", "İletişim", "Göreve İlişkin Sorular", "Çalışma Koşulları", "Eğitim /Gelişim", "Kariyer", "Ücret Sosyal Yardımlar ve Ödüllendirme", "Genel Algı"];
        else
            $groups = ["default"];

        $isFirstDescription = true;

        foreach ($jsonData as $value) {
            if ($value->type == "description") {
                if (! $isFirstDescription)
                    $isFirstDescription = false;
                else
                    $groupIndex++;

                continue;
            }

            $filterResults = array_filter($answerData, function ($v, $k) use ($value) {
                $decodedJson = json_decode($v->data, true);
                if ($decodedJson == null)
                    return false;

                if ($value->type == "checkbox") {
                    foreach ($value->answers as $answerKey => $answerValue) 
                        if (array_key_exists($value->slug . $answerKey, $decodedJson)) 
                            return true;
                } 
                else 
                    return array_key_exists($value->slug, $decodedJson); 
                
                return false;
            }, ARRAY_FILTER_USE_BOTH); 
            
            foreach ($filterResults as $fValue) {
                $decodedJson = json_decode($fValue->data, true);

                $group0 = $groups[$groupIndex];
                try {

                    if ($value->type == "checkbox") {
                        foreach ($value->answers as $akey => $avalue) {

                            if(!isset($decodedJson[$value->slug.$akey]))
                                continue;
                            
                            $answerValue = $decodedJson[$value->slug.$akey];

                            $answerTitle = $value->answers[$answerValue];

                            #foreach ($value->answers as $answer)
                            #$generatedData[$group0][$value->slug][$answer] = [];

                            $generatedData[$group0][$value->type . "::" . $value->title][$answerTitle][] = (object) [
                                "id" => $fValue->personalId,
                                "fullname" => $fValue->fullname,
                                "department" => $fValue->department,
                                #"answer" => $answerTitle,
                                "value" => $answerValue
                            ];
                        }

                        continue;
                    }

                    $answerValue = $decodedJson[$value->slug];

                    if ($value->type == "textarea") {
                        $generatedData[$group0][$value->type . "::" . $value->title][] = (object) [
                            "id" => $fValue->personalId,
                            "fullname" => $fValue->fullname,
                            "department" => $fValue->department,
                            #"answer" => $answerTitle,
                            "value" => $answerValue
                        ];

                        continue;
                    }
                    
                    $answerTitle = $value->answers[$answerValue];

                    #foreach ($value->answers as $answer)
                    #$generatedData[$group0][$value->slug][$answer] = [];

                    $generatedData[$group0][$value->type . "::" . $value->title][$answerTitle][] = (object) [
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
}