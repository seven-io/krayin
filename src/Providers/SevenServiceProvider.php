<?php

namespace Seven\Krayin\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Seven\Krayin\View\Components\Sms\Flash;
use Seven\Krayin\View\Components\Sms\From;
use Seven\Krayin\View\Components\Sms\PerformanceTracking;
use Seven\Krayin\View\Components\Sms\Text;
use Webkul\Admin\DataGrids\Contact\OrganizationDataGrid;
use Webkul\Admin\DataGrids\Contact\PersonDataGrid;

class SevenServiceProvider extends ServiceProvider {
    public function boot(): void {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'seven');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('seven/build'),
        ], 'public');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'seven');

        Event::listen('admin.layout.head.before', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('seven::style');
        });

        Blade::component('seven-sms-flash', Flash::class);
        Blade::component('seven-sms-text', Text::class);
        Blade::component('seven-sms-from', From::class);
        Blade::component('seven-sms-performance-tracking', PerformanceTracking::class);
    }

    public function register(): void {
        $this->registerConfig();

        $this->app->extend(PersonDataGrid::class,
            function (PersonDataGrid $service, $app) {
                $service->addAction([
                    'icon' => 'icon-seven',
                    'method' => 'GET',
                    'url'    => fn ($row) => route('admin.seven.sms', $row->id),
                    'title' =>  trans('seven::app.send_sms'),
                ]);
                return $service;
            });

        $this->app->extend(OrganizationDataGrid::class,
            function (OrganizationDataGrid $service, $app) {
                $service->addAction([
                    'icon' => 'icon-seven',
                    'method' => 'GET',
                    'url'    => fn ($row) => route('admin.seven.sms_organization', $row->id),
                    'title' => trans('seven::app.send_sms'),
                ]);
                return $service;
            });
    }

    protected function registerConfig(): void {
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/menu.php', 'menu.admin');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/acl.php', 'acl');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/core_config.php', 'core_config');
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/krayin-vite.php',
            'krayin-vite.viters'
        );
    }
}
