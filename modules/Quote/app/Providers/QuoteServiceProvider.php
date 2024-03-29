<?php

namespace Modules\Quote\app\Providers;

use App\Providers\AppServiceProvider;

class QuoteServiceProvider extends AppServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config.php', 'quotes');

        $this->app->register(RouteServiceProvider::class);
    }
}
