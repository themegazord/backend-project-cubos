<?php

namespace App\Providers;

use App\Repositories\Debtor\DebtorEloquentRepository;
use App\Repositories\Debtor\DebtorRepositoryInterface;
use App\Repositories\Installment\InstallmentEloquentRepository;
use App\Repositories\Installment\InstallmentRepositoryInterface;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Repositories\Auth\AuthEloquentRepository;
use App\Repositories\User\UserEloquentRepository;
use App\Repositories\User\UserRepositoryInterface;
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
    public function boot():void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthEloquentRepository::class);
        $this->app->bind(InstallmentRepositoryInterface::class, InstallmentEloquentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserEloquentRepository::class);
        $this->app->bind(DebtorRepositoryInterface::class, DebtorEloquentRepository::class);
    }
}
