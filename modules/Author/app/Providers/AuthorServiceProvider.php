<?php

namespace Modules\Author\app\Providers;

use Illuminate\Support\ServiceProvider;

class AuthorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../../config.php', 'author');

        $this->app->register(RouteServiceProvider::class);
    }
}
