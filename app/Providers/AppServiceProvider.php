<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            // Indispensable si l’app est dans un sous-dossier (ex. /devis-consulting/public/) :
            // sans ça, route() / asset URLs peuvent ignorer le chemin → CSRF / sessions incohérents.
            if ($root = rtrim((string) config('app.url'), '/')) {
                URL::forceRootUrl($root);
            }
        }
    }
}
