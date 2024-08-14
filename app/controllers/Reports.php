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
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Chart\Layout;

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
            if ($value->type != "description")
                $title[$value->slug] = html_entity_decode(strip_tags(trim($value->title)));

        $data["title"] = $title;

        #################
        $participators = Survey::participators($surveyId);

        foreach ($participators as $key => $participator) {
            if (!$participator->done)
                continue;

            $inline = [
                $participator->id,
                $participator->fullname
            ];

            $answerData = json_decode($participator->data, JSON_OBJECT_AS_ARRAY);

            foreach ($answerData as $answerKey => $answerValue) {

                $question = null;

                foreach ($questionData as $k => $v) {
                    if (str_starts_with($answerKey, $v->slug))
                        $question = $v;
                }

                if (empty($v) || !$question)
                    continue;

                if ($question->type == "checkbox") {
                    if (!array_key_exists($question->slug, $inline))
                        $inline[$question->slug] = null;

                    $inline[$question->slug] .= " → " . html_entity_decode(strip_tags(trim($question->answers[$answerValue])));
                    $inline[$question->slug] = trim($inline[$question->slug], " → ");
                } else
                    $inline[$question->slug] = html_entity_decode(strip_tags(trim($question->type == "textarea" ? $answerValue : $question->answers[$answerValue])));
            }

            $data[] = $inline;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Veriler');
        $sheet->fromArray($data);

        for ($colIndex = 0; $colIndex <= count($title); $colIndex++) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $cellCoordinate = $columnLetter . '1'; // 1. satır

            $sheetStyle = $sheet->getStyle($cellCoordinate);

            $sheetStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFC00000');
            $sheetStyle->getFont()->setColor(new Color(Color::COLOR_WHITE))->setSize(12);
            $sheetStyle->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM)->getColor()->setARGB('FF888888');
        }


        $result = Survey::report($survey);

        $startRow = 1;
        $chartsPerRow = 3;
        $chartWidth = 10; // Grafiğin genişliği (sütun sayısı)
        $chartHeight = 20; // Grafik yüksekliği (satır sayısı)

        $i = 0;
        $worksheet = new Worksheet(title: "Raporlar");

        foreach ($result as $key => $value) {
            // Kategoriler ve değerler dizisi
            $categories = array_map(fn($v) => html_entity_decode(strip_tags($v)), array_keys($value["answers"]));
            $values = array_map(fn($v) => html_entity_decode(strip_tags($v)), array_values($value["answers"]));
            // Dizileri hücrelere yazma
            $categoryColumnIndex = ($i % $chartsPerRow) * $chartWidth + 1; // Sütun indeksi (1'den başlar)
            $valueColumnIndex = $categoryColumnIndex + 1; // Bir sonraki sütun

            $categoryColumn = Coordinate::stringFromColumnIndex($categoryColumnIndex);
            $valueColumn = Coordinate::stringFromColumnIndex($valueColumnIndex);

            $startDataRow = $startRow + $i * $chartHeight;

            foreach ($categories as $index => $category) {
                $worksheet->setCellValue($categoryColumn . ($startDataRow + $index), $category);
                $worksheet->setCellValue($valueColumn . ($startDataRow + $index), $values[$index]);
            }

            // Grafik verileri
            $dataSeriesValues = new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_NUMBER,
                "Raporlar!\${$valueColumn}\$" . $startDataRow . ":\${$valueColumn}\$" . ($startDataRow + count($values) - 1)
            );
            $xAxisTickValues = new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_STRING,
                "Raporlar!\${$categoryColumn}\$" . $startDataRow . ":\${$categoryColumn}\$" . ($startDataRow + count($categories) - 1)
            );

            $series = new DataSeries(
                DataSeries::TYPE_BARCHART,
                DataSeries::GROUPING_CLUSTERED,
                range(0, count([$dataSeriesValues]) - 1),
                [],
                [$xAxisTickValues],
                [$dataSeriesValues]
            );

            $plotArea = new PlotArea(null, [$series]);
            $title = new Title(html_entity_decode(strip_tags($key)));

            $chart = new Chart(
                'chart' . ($i + 1),
                $title,
                new Legend(Legend::POSITION_RIGHT, null, false),
                $plotArea
            );

            // Grafiklerin pozisyonlarını dinamik olarak ayarlama
            $columnOffset = ($i % $chartsPerRow) * $chartWidth; // Yatay offset
            $rowOffset = floor($i / $chartsPerRow) * $chartHeight; // Dikey offset

            $chart->setTopLeftPosition(Coordinate::stringFromColumnIndex($columnOffset + 1) . ($startRow + $rowOffset));
            $chart->setBottomRightPosition(Coordinate::stringFromColumnIndex($columnOffset + $chartWidth) . ($startRow + $rowOffset + $chartHeight - 1));
            $worksheet->addChart($chart);

            $i++;
        }

        $spreadsheet->addSheet($worksheet);
        $writer = new Xlsx($spreadsheet);
        $writer->setIncludeCharts(true);
        $writer->save('php://output');
    }
}
