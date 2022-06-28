<?php

namespace OpenAdmin\Admin\Reporter;

use OpenAdmin\Admin\Admin;
use Illuminate\Routing\Router;

trait BootExtension
{
    public static function boot()
    {
        static::registerRoutes();

        static::importAssets();

        Admin::extend('reporter', __CLASS__);
    }

    /**
     * Register routes for open-admin.
     *
     * @return void
     */
    protected static function registerRoutes()
    {
        parent::routes(function ($router) {
            /* @var Router $router */
            $router->resource('exceptions', 'OpenAdmin\Admin\Reporter\ExceptionController');
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        parent::createMenu('Exception Reporter', 'exceptions', 'icon-bug');

        parent::createPermission('Exceptions reporter', 'ext.reporter', 'exceptions*');
    }

    public static function importAssets()
    {
        Admin::js('/vendor/open-admin-reporter/prism/prism.js');
        Admin::css('/vendor/open-admin-reporter/prism/prism.css');
    }
}
