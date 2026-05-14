<?php

namespace App\Providers;

use App\Models\Tasks;
use App\Observers\TaskObserver;
use App\Policies\TaskPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


    public function boot(): void
    {
        Paginator::useBootstrap();
        Tasks::observe(TaskObserver::class);

        Gate::policy(Tasks::class, TaskPolicy::class);

        Gate::before(function ($user, string $ability) {
            return method_exists($user, 'hasRole') && $user->hasRole('super_admin') ? true : null;
        });
    }
}
