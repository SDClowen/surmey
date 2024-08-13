<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Survey;
use Core\{Controller, Request, Database};
use Core\Attributes\route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reports extends Controller
{
    #[route(method: route::get | route::xhr_get, session: "user", otherwise: "/auth")]
    public function watch(int $surveyId)
    {
        $survey = Survey::existsByUserId(User::id(), "id", $surveyId);
        if (!$survey)
            redirect();

        $result = Survey::report($survey);

        $args = [
            "surveyTitle" => $survey->title,
            "user" => User::info(),
            "data" => $result,
            "anonymous" => $survey->anonymous,
            "surveyId" => $surveyId
        ];

        if (!$survey->anonymous)
            $args["participators"] = Survey::participators($surveyId);

        $this->view("main", "reports", lang("reports"), $args);
    }

    #[route(method: route::xhr_get)]
    public function reset(int $surveyId)
    {
        $survey = Survey::existsByUserId(User::id(), "id", $surveyId);
        if (!$survey)
            redirect();

        $count = Survey::reset($surveyId);
        if ($count)
            success(refresh: true);

        getDataError();
    }

    #[route(method: route::get)]
    public function csv(int $surveyId)
    {
        $survey = Survey::existsByUserId(User::id(), "id", $surveyId);
        if (!$survey)
            redirect();

        ob_clean();
        
        header('Pragma: private');
        header('Cache-control: private, must-revalidate');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $csvFileName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '-', $survey->title));
        header('Content-Disposition: attachment; filename=' . $csvFileName . '.xlsx');
        header('Cache-Control: max-age=0');
        $file = fopen('php://output', 'w');

        ##################################################

        $questionData = json_decode($survey->data);
        $questions = array_map(fn($v) => strip_tags(trim($v->title)), $questionData);

        $data = [
            array_merge(['Sicil No', 'Ad Soyad'], $questions)
        ];

        #################
        $participators = Survey::participators($surveyId);
        
        foreach ($participators as $key => $participator) {
            if(!$participator->done)
                continue;

            $inline = [
                $participator->id, 
                $participator->fullname
            ];

            
            $answerData = json_decode($participator->data);

            foreach ($answerData as $questionKey => $answerKey) {
                $question = current(array_filter($questionData, fn($val) => $val->slug == $questionKey));
                
                $inline[] = strip_tags(trim($question->type == "textarea" ? $answerKey : $question->answers[$answerKey]));
            }

            $data[] = $inline;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
