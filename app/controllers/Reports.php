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

        if(!$survey->anonymous)
            $args["participators"] = Survey::participators($surveyId);

        $this->view("main", "reports", lang("reports"), $args);
    }

    #[route(method: route::xhr_get)]
    public function reset(int $surveyId)
    {
        $survey = Survey::existsByUserId(User::id(), "id", $surveyId);
        if(!$survey)
            redirect();

        $count = Survey::reset($surveyId);
        if($count)
            success(refresh: true);

        getDataError();
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
        $csvFileName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '-', $survey->title));
        header('Content-Disposition: attachment; filename=' . $csvFileName . '.csv');

        $fp = fopen('php://output', 'w');

        $report = Survey::report($survey);

        #values
        foreach($report as $title => $data)
        {
            foreach($data["answers"] as $answerTitle => $participateCount)
            {
                $answerData[] = $answerTitle;
                $valueData[] = $participateCount;
            }

            fputcsv($fp, [$title]);
            fputcsv($fp, $answerData);
            fputcsv($fp, $valueData);
        }

        fclose($fp);
        exit;
    }
}