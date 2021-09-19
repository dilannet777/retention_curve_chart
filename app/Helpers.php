<?php

function get_week_start_date($date){
    $timestamp=strtotime($date);
    if (!$timestamp) return false;
    $dayOfWeek = date('w', $timestamp);
    $secondsPerDay=3600*24;
    return date('Y-m-d',$timestamp-$secondsPerDay*$dayOfWeek);

}

function retention_chart_metrix($chartData,$options=[]){
    if (!isset($chartData)) return false;
    $chartMetrix=[];
    foreach ($chartData as $dateKey=>$steps){
        if (!is_array($steps)) continue;
        $randomColor=sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        $weekMetrix=[];
        $weekMetrix['label']=$dateKey;
        $weekMetrix['borderColor']=$randomColor;
        $weekMetrix['pointBorderColor']=$randomColor;
        $weekMetrix['pointBackgroundColor']=!empty($options['point_background_color'])?$options['point_background_color']:'white';
        $weekMetrix['borderWidth'] = !empty($options['point_background_color'])?$options['border_width']:1;
        $weekMetrix['fill'] = $options['fill']?$options['fill']:false;
        $maxOnboards=max(array_values($steps));
        if ($maxOnboards<=0)  continue;
        foreach ($steps as $step){
            $weekMetrix['data'][]=round($step/$maxOnboards*100);
        }

        $chartMetrix[]=$weekMetrix;
        
    }
    
    

    return $chartMetrix;

}

function get_chart_options($options){

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
                        'display'=>true,
                        'scaleLabel'=>[
                                'display'=> true,
                                'labelString'=>$options['yLabel']
                        ]
                    ]
                ],

                'xAxes' => [[
                    'gridLines' => [
                        'display' => false
                    ],
                    'scaleLabel'=>[
                        'display'=> true,
                        'labelString'=> $options['xLabel']
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