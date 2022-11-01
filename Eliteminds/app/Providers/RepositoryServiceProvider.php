<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Repository Interface array
     * @var array
     */
    private $repositories = [
        'App\Repository\PackageRepositoryInterface'         => 'App\Repository\Package\PackageRepository',
        'App\Repository\PostRepositoryInterface'            => 'App\Repository\Post\PostRepository',
        'App\Repository\ExplanationRepositoryInterface'     => 'App\Repository\Explanation\ExplanationRepository',
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Bind repositories defined in repositories array
         */
        foreach($this->repositories as $interface => $repo){
            $this->app->bind($interface, $repo);
        }
    }
}
