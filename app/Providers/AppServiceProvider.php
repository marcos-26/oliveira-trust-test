<?php

namespace App\Providers;

use App\Domain\Services\PagarMeIntegrationService;
use App\Domain\Services\PagarmeMockService;
use App\Http\Controllers\PagamentoController;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        if (env('USE_SERVICE_MOCKS')) {
            $this->app->bind(PagarMeIntegrationService::class, PagarmeMockService::class);
        } else {
            $this->app->bind(PagarMeIntegrationService::class, function ($app) {
                // Aqui você pode retornar a implementação real
                return new PagarMeIntegrationService(/* argumentos de construtor, se houver */);
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
