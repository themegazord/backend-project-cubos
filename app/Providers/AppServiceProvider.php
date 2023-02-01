<?php

namespace App\Providers;

use App\Repositories\Installment\InstallmentEloquentRepository;
use App\Repositories\Installment\InstallmentRepositoryInterface;
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
        $this->app->bind(UserRepositoryInterface::class, UserEloquentRepository::class);
        $this->app->bind(InstallmentRepositoryInterface::class, InstallmentEloquentRepository::class);
    }
}
