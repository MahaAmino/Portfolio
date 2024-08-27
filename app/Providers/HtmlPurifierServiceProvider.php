<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlPurifierServiceProvider extends ServiceProvider
{
    public function register(): void
    {
$this->app->singleton('purifier',function(){$config=HTMLPurifier_Config::createDefault();
return new HTMLPurifier($config);});
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
