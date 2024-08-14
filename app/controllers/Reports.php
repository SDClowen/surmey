<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Survey;
use Core\{Controller, Request, Database};
use Core\Attributes\route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;

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

        $questionData = json_decode($survey->data);
        $title = ['Sicil No', 'Ad Soyad'];

        foreach ($questionData as $value)
            if($value->type != "description")
                $title[$value->slug] = html_entity_decode(strip_tags(trim($value->title)));

        $data["title"] = $title;

        #################
        $participators = Survey::participators($surveyId);
        
        foreach ($participators as $key => $participator) {
            if(!$participator->done)
                continue;

            $inline = [
                $participator->id, 
                $participator->fullname
            ];
            
            $answerData = json_decode($participator->data, JSON_OBJECT_AS_ARRAY);
           
            foreach ($answerData as $answerKey => $answerValue) {

                $question = null;

                foreach ($questionData as $k => $v) {
                    if(str_starts_with($answerKey,$v->slug))
                        $question = $v;
                }

                if(empty($v) || !$question)
                    continue;

                if($question->type == "checkbox")
                {
                    if(!array_key_exists($question->slug, $inline))
                        $inline[$question->slug] = null;

                    $inline[$question->slug] .= " → ".html_entity_decode(strip_tags(trim($question->answers[$answerValue])));
                    $inline[$question->slug] = trim($inline[$question->slug], " → ");
                }
                else 
                    $inline[$question->slug] = html_entity_decode(strip_tags(trim($question->type == "textarea" ? $answerValue : $question->answers[$answerValue])));
            }

            $data[] = $inline;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);

        for ($colIndex = 0; $colIndex <= count($title); $colIndex++) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $cellCoordinate = $columnLetter . '1'; // 1. satır

            $sheetStyle = $sheet->getStyle($cellCoordinate);

            $sheetStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFC00000');
            $sheetStyle->getFont()->setColor(new Color(Color::COLOR_WHITE))->setSize(12);
            $sheetStyle->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM)->getColor()->setARGB('FF888888');
        }
        

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
