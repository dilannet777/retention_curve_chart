<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\Helper;


class RetentionChartRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_chart_data_is_loading()
    {
        $exportFilePath=dirname(dirname(dirname(__FILE__))).'/storage/json/export.json';
        
        $output  = (new \App\Repositories\Json\RetentionChartRepository($exportFilePath))->all();

        $this->assertFalse(empty($output));
    }

}