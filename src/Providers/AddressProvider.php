<?php

namespace Cwp\Address\Providers;

use Illuminate\Support\ServiceProvider;

class AddressProvider extends ServiceProvider
{
    protected $commands = [
        'Cwp\Address\Commands\Install',
    ];

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    public function register(){
        $this->commands($this->commands);
    }
}
