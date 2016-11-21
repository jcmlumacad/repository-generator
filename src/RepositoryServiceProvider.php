<?php

namespace Conds18\Repository;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositoryGenerator();
    }

    /**
     * Register the make:repository generator.
     */
    private function registerRepositoryGenerator()
    {
        $this->app->singleton('command.conds18.repository', function($app) {
            return $app['Conds18\Repository\Commands\Make\Repository'];
        });

        $this->commands('command.conds18.repository');
    }
}
