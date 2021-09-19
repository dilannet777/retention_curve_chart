<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getOnboardingFlowChart()
    {

        $filePath = @storage_path() . '/json/export.json';

        try {
            $jsonString = file_get_contents($filePath, true);
        } catch (Exception $e) {
            return response(
                ['error' => __('common.file_missing_err', ['path' => $filePath])],
                422
            );
        }


        $chartData = json_decode($jsonString, true);

        $chartArray = [];
        $stepArr = [0, 20, 40, 50, 70, 90, 99, 100];
        foreach ($chartData as $item) {
            if (empty($item['created_at']) || empty($item['onboarding_perentage'])) continue;//I recommand this becuase of chart will be rendeared by existing data
            //if (is_valid_record($item,['created_at'=>['required'=>true,'date'=>true],'onboarding_perentage'=>['required'=>true,'numeric'=>true]])) return false;//testing
            $weekStartDate = get_week_start_date($item['created_at']);
            if (empty($weekStartDate)) continue;
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
                ], 'options' => get_chart_options(['xLabel' => __('common.xLabel'), 'yLabel' => __('common.yLabel')])
            ],
            200
        );
    }
}
