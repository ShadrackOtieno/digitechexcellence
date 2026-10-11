<?php

namespace App\Providers;

use App\Models\ContactMessage;
use App\Models\Inquiry;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        require_once app_path('Support/helpers.php');

        // Some local MySQL installs (older WAMP/XAMPP) default to MyISAM, which has a 1000-byte index limit
        // and ignores foreign keys. Force InnoDB so migrations behave the same everywhere.
        config(['database.connections.mysql.engine' => 'InnoDB', 'database.connections.mariadb.engine' => 'InnoDB']);
    }

    public function boot(): void
    {
        // Keeps indexed string columns within index limits on older MySQL/MariaDB versions.
        Schema::defaultStringLength(191);

        // Site settings are available as $site in EVERY view (layouts and the pages inside them).
        View::composer('*', function ($view) {
            static $shared = null;
            if ($shared === null) {
                try {
                    $shared = ['site' => Setting::map()];
                } catch (\Throwable $e) {
                    $shared = ['site' => []];
                }
            }
            $view->with($shared);
        });

        // Only the layouts need these, so pages never depend on them.
        View::composer('layouts.site', function ($view) {
            try {
                $view->with('footerServices', Service::active()->limit(6)->get());
            } catch (\Throwable $e) {
                $view->with('footerServices', collect());
            }
        });

        View::composer('layouts.admin', function ($view) {
            try {
                $view->with('badges', [
                    'inquiries' => Inquiry::where('status', 'new')->count(),
                    'messages' => ContactMessage::where('is_read', false)->count(),
                ]);
            } catch (\Throwable $e) {
                $view->with('badges', ['inquiries' => 0, 'messages' => 0]);
            }
        });
    }
}
