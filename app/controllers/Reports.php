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

    #[route(method: route::get)]
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

            fputcsv($fp, $csvData);
        }

        fclose($fp);
        exit;
    }
}