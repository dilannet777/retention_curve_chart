<?php

namespace App\Http\Controllers;

//
use App\Repositories\ChartRepositoryInterface;
use App\Helpers\Helper;

class RetentionChartController extends Controller
{


    private $retentionChartRepository;

    public function __construct(ChartRepositoryInterface $RetentionChartRepository)
    {
        $this->retentionChartRepository = $RetentionChartRepository;
    }

    public function getRetentionChartData()
    {


        $retentionChartData = $this->retentionChartRepository->all();

        if (empty($retentionChartData)) {
            return response(
                ['error' => __('common.onboard_data_empty')],
                422
            );
        }

        $weeklyOnboardCohortData = Helper::get_vue_cohort_line_chart_data([
            'line_chart_data' => $retentionChartData,
            'xaxes_labels' => [0, 20, 40, 50, 70, 90, 99, 100],
            'cohort_function' => 'get_week_start_date',
            'cohort_group_name' => 'created_at',
            'cohort_group_value' => 'onboarding_perentage'
        ]);

        return response(
            [
                'chartdata' => $weeklyOnboardCohortData, 'options' => Helper::get_vue_chart_options(['xLabel' => __('common.xLabel'), 'yLabel' => __('common.yLabel')])
            ],
            200
        );
    }
}
