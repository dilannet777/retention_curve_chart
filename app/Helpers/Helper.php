<?php


namespace App\Helpers;

class Helper
{

    //returns week start date (Monday)
    public static function get_week_start_date($date)
    {
        $timestamp = strtotime($date);
        if (!$timestamp) return false;
        $dayOfWeek = date('w', $timestamp);
        $secondsPerDay = 3600 * 24;
        return date('Y-m-d', $timestamp - $secondsPerDay * $dayOfWeek);
    }
    //returns vuejs chart line chart metrix
    public static function retention_chart_metrix($chartData, $options = [])
    {
        if (empty($chartData)) return false;
        $chartMetrix = [];
        foreach ($chartData as $dateKey => $steps) {
            if (!is_array($steps)) continue;
            $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $weekMetrix = [];
            $weekMetrix['label'] = $dateKey;
            $weekMetrix['borderColor'] = $randomColor;
            $weekMetrix['pointBorderColor'] = $randomColor;
            $weekMetrix['pointBackgroundColor'] = !empty($options['point_background_color']) ? $options['point_background_color'] : 'white';
            $weekMetrix['borderWidth'] = !empty($options['point_background_color']) ? $options['border_width'] : 1;
            $weekMetrix['fill'] = !empty($options['fill']) ? $options['fill'] : false;
            $maxOnboards = max(array_values($steps));
            if ($maxOnboards <= 0)  continue;
            foreach ($steps as $step) {
                $weekMetrix['data'][] = round($step / $maxOnboards * 100);
            }

            $chartMetrix[] = $weekMetrix;
        }

        return $chartMetrix;
    }

    //returns vuejs chart line chart options
    public static function get_vue_chart_options($options)
    {

        return [
            'scales' => [
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true
                        ],
                        'gridLine' => [
                            'display' => true
                        ],
                        'display' => true,
                        'scaleLabel' => [
                            'display' => true,
                            'labelString' => $options['yLabel']
                        ]
                    ]
                ],

                'xAxes' => [[
                    'gridLines' => [
                        'display' => false
                    ],
                    'scaleLabel' => [
                        'display' => true,
                        'labelString' => $options['xLabel']
                    ]
                ]]
            ],
            'legend' => [
                'display' => true
            ],
            'responsive' => true,
            'maintainAspectRatio' => false

        ];
    }
    //validate csv file record
    public static function is_valid_record($item, $rules)
    {
        if (empty($rules) || empty($item)) return false;
        $status = true;
        foreach ($rules as $field => $ru) {

            if ((!empty($ru['required']) && $ru['required'] === true &&  empty($item[$field]))
                || (!empty($ru['numeric']) && $ru['numeric'] === true &&  !is_numeric($item[$field]))
                || (!empty($ru['date']) && $ru['date'] === true &&  strtotime($item[$field]) > 0)
            ) $status = false;
        }
        return $status;
    }

    public static function get_vue_cohort_line_chart_data($lineChartData){
  
        $cohortData = [];


        if (empty($lineChartData['line_chart_data']) 
         || empty($lineChartData['cohort_group_name']) 
         || empty($lineChartData['cohort_group_value']) 
         || empty($lineChartData['cohort_function'])
         || empty($lineChartData['xaxes_labels'])
         
        ) return false;

        $cohortFunction=$lineChartData['cohort_function'];

        if (!method_exists('Helper',$cohortFunction)) return false;

        foreach ($lineChartData['line_chart_data'] as $item) {
            if (empty($item[$lineChartData['cohort_group_name']]) || empty($item[$lineChartData['cohort_group_value']])) continue;//I recommand this becuase of chart will be rendeared by existing data
            //if (is_valid_record($item,['created_at'=>['required'=>true,'date'=>true],'onboarding_perentage'=>['required'=>true,'numeric'=>true]])) return false;//testing
            
           
            $cohortKeyName = self::$cohortFunction($item[$lineChartData['cohort_group_name']]);
    
            if (empty($cohortKeyName)) continue;
            if (!isset($cohortData[$cohortKeyName]))$cohortData[$cohortKeyName] = [];
            foreach($lineChartData['xaxes_labels'] as $step) {
                if ($step <= $item[$lineChartData['cohort_group_value']]) {
                    if (!isset($cohortData[$cohortKeyName][$step])) $cohortData[$cohortKeyName][$step] = 0;
                    $cohortData[$cohortKeyName][$step]++;
                }
            }
        }


        return [
            'labels' => $lineChartData['xaxes_labels'],

            'datasets' => self::retention_chart_metrix($cohortData)
        ];


    }

}
