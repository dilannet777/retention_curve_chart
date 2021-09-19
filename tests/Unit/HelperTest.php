<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\ChartController;

class HeleperTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */


    public function test_date_format_is_invalid(){

        $output= get_week_start_date('---');
        $this->assertEquals(false,$output);
    }

    public function test_chart_data_empty(){

        $output=retention_chart_metrix([]);
        $this->assertEquals(false,$output);
    }

    public function test_is_empty_record(){
        $output=is_valid_record(['created_at'=>'','onboarding_perentage'=>''],['created_at'=>['required'=>true,'date'=>true],'onboarding_perentage'=>['required'=>true,'numeric'=>true]]);
    
        $this->assertEquals(false,$output);

    }

    public function test_is_invalid_date_record(){
        $output=is_valid_record(['created_at'=>'---','onboarding_perentage'=>''],['created_at'=>['required'=>true,'date'=>true],'onboarding_perentage'=>['required'=>true,'numeric'=>true]]);
    
        $this->assertEquals(false,$output);

    }

    public function test_is_invalid_numeric_record(){
        $output=is_valid_record(['created_at'=>'','onboarding_perentage'=>'--'],['created_at'=>['required'=>true,'date'=>true],'onboarding_perentage'=>['required'=>true,'numeric'=>true]]);
    
        $this->assertEquals(false,$output);

    }

    public function test_is_invalid_date_and_numeric_record(){
        $output=is_valid_record(['created_at'=>'---','onboarding_perentage'=>'--'],['created_at'=>['required'=>true,'date'=>true],'onboarding_perentage'=>['required'=>true,'numeric'=>true]]);
    
        $this->assertEquals(false,$output);

    }



    



}
