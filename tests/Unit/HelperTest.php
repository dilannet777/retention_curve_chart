<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\Helper;

class HeleperTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */


    public function test_date_format_is_invalid()
    {

        $output = Helper::get_week_start_date('---');
        $this->assertEquals(false, $output);
    }

    public function test_chart_data_empty()
    {

        $output = Helper::retention_chart_metrix([]);
        $this->assertEquals(false, $output);
    }

    public function test_is_empty_record()
    {
        $output = Helper::is_valid_record(['created_at' => '', 'onboarding_perentage' => ''], ['created_at' => ['required' => true, 'date' => true], 'onboarding_perentage' => ['required' => true, 'numeric' => true]]);

        $this->assertEquals(false, $output);
    }

    public function test_is_invalid_date_record()
    {
        $output = Helper::is_valid_record(['created_at' => '---', 'onboarding_perentage' => ''], ['created_at' => ['required' => true, 'date' => true], 'onboarding_perentage' => ['required' => true, 'numeric' => true]]);

        $this->assertEquals(false, $output);
    }

    public function test_is_invalid_numeric_record()
    {
        $output = Helper::is_valid_record(['created_at' => '', 'onboarding_perentage' => '--'], ['created_at' => ['required' => true, 'date' => true], 'onboarding_perentage' => ['required' => true, 'numeric' => true]]);

        $this->assertEquals(false, $output);
    }

    public function test_is_invalid_date_and_numeric_record()
    {
        $output = Helper::is_valid_record(['created_at' => '---', 'onboarding_perentage' => '--'], ['created_at' => ['required' => true, 'date' => true], 'onboarding_perentage' => ['required' => true, 'numeric' => true]]);

        $this->assertEquals(false, $output);
    }

    public function test_is_line_chart_data_empty()
    {
        $output = Helper::is_valid_record(['created_at' => '---', 'onboarding_perentage' => '--'], ['created_at' => ['required' => true, 'date' => true], 'onboarding_perentage' => ['required' => true, 'numeric' => true]]);

        $this->assertEquals(false, $output);
    }


    function test_vue_cohort_line_chart_data_empty()
    {
        $output = Helper::get_vue_cohort_line_chart_data([
            'line_chart_data' => [],
            'xaxes_labels' => [0, 20, 40, 50, 70, 90, 99, 100],
            'cohort_function' => 'get_week_start_date',
            'cohort_group_name' => 'created_at',
            'cohort_group_value' => 'onboarding_perentage'
        ]);

        $this->assertEquals(false, $output);
    }

    function test_vue_xaxes_labels_empty()
    {
        $output = Helper::get_vue_cohort_line_chart_data([
            'line_chart_data' => [[
                    'created_at'=>'7/19/16',
                    'onboarding_perentage'=>10,

            ]],
            'xaxes_labels' => [],
            'cohort_function' => 'get_week_start_date',
            'cohort_group_name' => 'created_at',
            'cohort_group_value' => 'onboarding_perentage'
        ]);

        $this->assertEquals(false, $output);
    }

    function test_vue_cohort_function_empty()
    {
        $output = Helper::get_vue_cohort_line_chart_data([
            'line_chart_data' => [[
                    'created_at'=>'7/19/16',
                    'onboarding_perentage'=>10,

            ]],
            'xaxes_labels' => [0, 20, 40, 50, 70, 90, 99, 100],
            'cohort_function' => null,
            'cohort_group_name' => 'created_at',
            'cohort_group_value' => 'onboarding_perentage'
        ]);

        $this->assertEquals(false, $output);
    }

    function test_vue_cohort_function_not_exist()
    {
        $output = Helper::get_vue_cohort_line_chart_data([
            'line_chart_data' => [[
                    'created_at'=>'7/19/16',
                    'onboarding_perentage'=>10,

            ]],
            'xaxes_labels' => [0, 20, 40, 50, 70, 90, 99, 100],
            'cohort_function' => 'test',
            'cohort_group_name' => 'created_at',
            'cohort_group_value' => 'onboarding_perentage'
        ]);

        $this->assertEquals(false, $output);
    }

    function test_vue_cohort_group_name_empty()
    {
        $output = Helper::get_vue_cohort_line_chart_data([
            'line_chart_data' => [[
                    'created_at'=>'7/19/16',
                    'onboarding_perentage'=>10,

            ]],
            'xaxes_labels' => [0, 20, 40, 50, 70, 90, 99, 100],
            'cohort_function' => 'get_week_start_date',
            'cohort_group_name' => '',
            'cohort_group_value' => 'onboarding_perentage'
        ]);

        $this->assertEquals(false, $output);
    }

    function test_vue_onboarding_perentage_empty()
    {
        $output = Helper::get_vue_cohort_line_chart_data([
            'line_chart_data' => [[
                    'created_at'=>'7/19/16',
                    'onboarding_perentage'=>10,

            ]],
            'xaxes_labels' => [0, 20, 40, 50, 70, 90, 99, 100],
            'cohort_function' => 'get_week_start_date',
            'cohort_group_name' => 'created_at',
            'cohort_group_value' => ''
        ]);

        $this->assertEquals(false, $output);
    }


 
}
