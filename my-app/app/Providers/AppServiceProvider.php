<?php
namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

use App\Models\Car;
use App\Models\User;

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

        Gate::define('edit-car', function (User $user, Car $car) {
            return $car->driver->user->is($user);
        });
    }
}
