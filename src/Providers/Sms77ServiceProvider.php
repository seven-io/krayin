<?php

namespace Sms77\Krayin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\DataGrids\Contact\OrganizationDataGrid;
use Webkul\Admin\DataGrids\Contact\PersonDataGrid;

class Sms77ServiceProvider extends ServiceProvider {
    /**
     * Bootstrap services.
     * @return void
     */
    public function boot() {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'sms77');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('vendor/sms77/assets'),
        ], 'public');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'sms77');

        Event::listen('admin.layout.head', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('sms77::layouts.style');
        });

        $this->app->register(ModuleServiceProvider::class);
    }

    /**
     * Register services.
     * @return void
     */
    public function register() {
        $this->registerConfig();

        $this->app->extend(PersonDataGrid::class,
            function (PersonDataGrid $service, $app) {
                $service->addAction([
                    'icon' => 'sms77-icon',
                    'method' => 'GET',
                    'route' => 'admin.sms77.sms',
                    'title' => trans('sms77::app.send_sms'),
                ]);
                return $service;
            });

        $this->app->extend(OrganizationDataGrid::class,
            function (OrganizationDataGrid $service, $app) {
                $service->addAction([
                    'icon' => 'sms77-icon',
                    'method' => 'GET',
                    'route' => 'admin.sms77.sms_organization',
                    'title' => trans('sms77::app.send_sms'),
                ]);
                return $service;
            });
    }

    /**
     * Register package config.
     * @return void
     */
    protected function registerConfig() {
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/menu.php', 'menu.admin');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/acl.php', 'acl');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/system.php', 'core_config');
    }
}