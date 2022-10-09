<?php

namespace App\Providers;

use App\Repositories\Asset\AssetRepository;
use App\Repositories\Asset\AssetRepositoryInterface;
use App\Services\Asset\AssetService;
use App\Services\Asset\AssetServiceInterface;
use App\Services\CoinGecko\CoinService;
use App\Services\CoinGecko\CoinServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CoinServiceInterface::class, CoinService::class);
        $this->app->bind(AssetServiceInterface::class, AssetService::class);
        $this->app->bind(AssetRepositoryInterface::class, AssetRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::unguard();
    }
}
