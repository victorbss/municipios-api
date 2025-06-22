<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MunicipioProviderInterface;
use App\Services\BrasilApiMunicipioProvider;
use App\Services\IbgeMunicipioProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MunicipioProviderInterface::class, function () {
            return env('MUNICIPIO_PROVIDER') === 'IBGE'
                    ? new IbgeMunicipioProvider()
                    : new BrasilApiMunicipioProvider();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
