<?php

namespace App\Repositories\Json;


use App\Repositories\ChartRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Exception;

class RetentionChartRepository implements ChartRepositoryInterface
{

    /**
     * RetentionChartRepository constructor.
     *
     * 
     */
    public function __construct($exportFilePath='')
    {
        
        try {
            $filePath =  storage_path() . '/json/export.json';
        } catch (Exception $e) {//this will happened while unit testing
            $filePath =$exportFilePath;

        }

        $jsonString = @file_get_contents($filePath, true);
       
        $this->retentionChartDataModel = json_decode($jsonString, true);
    }


    public function all()
    {
        return $this->retentionChartDataModel;   
    }
}
