<?php

namespace App\Providers;

use App\Models\ExaminationCategory;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        /*
         * Share the system identity (name, acronym, logo, contact info)
         * and the examination categories/levels with EVERY view in the
         * system. This is what makes the "change once, updates
         * everywhere" behaviour work: layouts, dropdowns, certificates,
         * emails, etc. all read from $systemSettings / $examinationCategories
         * instead of hardcoded text.
         *
         * Wrapped in a Schema::hasTable check so nothing breaks on a
         * fresh install before migrations have run (e.g. during
         * `composer install` on a brand new client server).
         */
        View::composer('*', function ($view) {
            static $settings = null;
            static $categories = null;

            if ($settings === null) {
                try {
                    $settings   = Schema::hasTable('system_settings') ? SystemSetting::current() : null;
                    $categories = Schema::hasTable('examination_categories') ? ExaminationCategory::allWithLevels() : collect();
                } catch (\Throwable $e) {
                    $settings   = null;
                    $categories = collect();
                }
            }

            $view->with('systemSettings', $settings);
            $view->with('examinationCategories', $categories);
        });
    }
}
