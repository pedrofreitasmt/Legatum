<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        Model::automaticallyEagerLoadRelationships();

        Gate::define('viewAdminPanel', function ($user) {
            return $user->is_admin;
        });

        $this->configureCommands();
        $this->configureModels();
        $this->configureVite();
    }

    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->environment('production'),
        );
    }

    private function configureModels(): void
    {
        Model::shouldBeStrict();

        Model::unguard();
    }

    private function configureVite(): void
    {
        Vite::usePrefetchStrategy('agressive');
    }
}
