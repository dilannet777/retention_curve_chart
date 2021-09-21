<?php

namespace App\Providers;


use App\Repositories\ChartRepositoryInterface; 
use App\Repositories\Json\RetentionChartRepository;
use Illuminate\Support\ServiceProvider; 

/** 
* Class RepositoryServiceProvider 
* @package App\Providers 
*/ 

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ChartRepositoryInterface::class, RetentionChartRepository::class);
    }

}
