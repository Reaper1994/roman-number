<?php

namespace App\Providers;

use App\Contracts\ConversionRepositoryInterface;
use App\Repositories\ConversionRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(ConversionRepositoryInterface::class, ConversionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
//        JsonResource::withoutWrapping();
    }
}
