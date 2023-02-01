<?php

namespace App\Providers;

use App\Repositories\Installment\InstallmentEloquentRepository;
use App\Repositories\Installment\InstallmentRepositoryInterface;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Repositories\Auth\AuthEloquentRepository;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthEloquentRepository::class);
        $this->app->bind(InstallmentRepositoryInterface::class, InstallmentEloquentRepository::class);
    }
}
