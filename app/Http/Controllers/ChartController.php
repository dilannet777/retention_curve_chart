<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getOnboardingFlowChart()
    {


        $jsonString = file_get_contents(storage_path() . '/json/export.json');

        $chartData = json_decode($jsonString, true);

        $chartArray = [];
        $stepArr = [0, 20, 40, 50, 70, 90, 99, 100];
        foreach ($chartData as $item) {
            if (empty($item['created_at']) || empty($item['onboarding_perentage'])) continue;
            $weekStartDate = get_week_start_date($item['created_at']);
            if (!isset($chartArray[$weekStartDate])) $chartArray[$weekStartDate] = [];
            foreach ($stepArr as $step) {

                if ($step <= $item['onboarding_perentage']) {

                    if (!isset($chartArray[$weekStartDate][$step])) $chartArray[$weekStartDate][$step] = 0;
                    $chartArray[$weekStartDate][$step]++;
                }
            }
        }

        return response(
            [
                'chartdata' => [
                    'labels' => $stepArr,

                    'datasets' => retention_chart_metrix($chartArray)
                ], 'options' => get_chart_options(['xLabel'=>'Current Steps in Registration','yLabel'=>'Total Onboarded'])
            ],
            200
        );
    }
}
