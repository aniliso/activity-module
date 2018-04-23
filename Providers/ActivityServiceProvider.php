<?php

namespace Modules\Activity\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Activity\Events\Handlers\RegisterActivitySidebar;

class ActivityServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration, CanGetSidebarClassForModule;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();

        $this->app->extend('asgard.ModulesList', function($app) {
            array_push($app, 'activity');
            return $app;
        });

        $this->app['events']->listen(
            BuildingSidebar::class,
            $this->getSidebarClassForModule('Activity', RegisterActivitySidebar::class)
        );

        \Widget::register('activityLatest', '\Modules\Activity\Widgets\ActivityWidget@latest');
        \Widget::register('eventLatest', '\Modules\Activity\Widgets\EventWidget@latest');
        \Widget::register('eventsCalendar', '\Modules\Activity\Widgets\ActivityWidget@events');
    }

    public function boot()
    {
        $this->publishConfig('activity', 'permissions');
        $this->publishConfig('activity', 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Activity\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Activity\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Activity\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Activity\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Activity\Repositories\LocationRepository',
            function () {
                $repository = new \Modules\Activity\Repositories\Eloquent\EloquentLocationRepository(new \Modules\Activity\Entities\Location());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Activity\Repositories\Cache\CacheLocationDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Activity\Repositories\ActivityRepository',
            function () {
                $repository = new \Modules\Activity\Repositories\Eloquent\EloquentActivityRepository(new \Modules\Activity\Entities\Activity());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Activity\Repositories\Cache\CacheActivityDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Activity\Repositories\EventRepository',
            function () {
                $repository = new \Modules\Activity\Repositories\Eloquent\EloquentEventRepository(new \Modules\Activity\Entities\Event());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Activity\Repositories\Cache\CacheEventDecorator($repository);
            }
        );
// add bindings
    }
}
