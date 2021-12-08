<?php

namespace App\Providers;



use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('filter', function($attribute, $value, $params){
            foreach($params as $word){
                if(stripos($value, $word) !== false){
                    // it includes one of the bad words
                    // $this->filtered[] = $word;
                    return false;
                }
            }
            
            // return empty($this->filtered);
            return true;
        }, 'Some words are not allowed');
        
        Paginator::useBootstrap();
    }
}
