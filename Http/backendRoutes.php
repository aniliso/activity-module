<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/activity'], function (Router $router) {
    $router->bind('activityCategory', function ($id) {
        return app('Modules\Activity\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.activity.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:activity.categories.index'
    ]);
    $router->get('categories/create', [
        'as' => 'admin.activity.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:activity.categories.create'
    ]);
    $router->post('categories', [
        'as' => 'admin.activity.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:activity.categories.create'
    ]);
    $router->get('categories/{activityCategory}/edit', [
        'as' => 'admin.activity.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:activity.categories.edit'
    ]);
    $router->put('categories/{activityCategory}', [
        'as' => 'admin.activity.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:activity.categories.edit'
    ]);
    $router->delete('categories/{activityCategory}', [
        'as' => 'admin.activity.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:activity.categories.destroy'
    ]);
    $router->bind('location', function ($id) {
        return app('Modules\Activity\Repositories\LocationRepository')->find($id);
    });
    $router->get('locations', [
        'as' => 'admin.activity.location.index',
        'uses' => 'LocationController@index',
        'middleware' => 'can:activity.locations.index'
    ]);
    $router->get('locations/create', [
        'as' => 'admin.activity.location.create',
        'uses' => 'LocationController@create',
        'middleware' => 'can:activity.locations.create'
    ]);
    $router->post('locations', [
        'as' => 'admin.activity.location.store',
        'uses' => 'LocationController@store',
        'middleware' => 'can:activity.locations.create'
    ]);
    $router->get('locations/{location}/edit', [
        'as' => 'admin.activity.location.edit',
        'uses' => 'LocationController@edit',
        'middleware' => 'can:activity.locations.edit'
    ]);
    $router->put('locations/{location}', [
        'as' => 'admin.activity.location.update',
        'uses' => 'LocationController@update',
        'middleware' => 'can:activity.locations.edit'
    ]);
    $router->delete('locations/{location}', [
        'as' => 'admin.activity.location.destroy',
        'uses' => 'LocationController@destroy',
        'middleware' => 'can:activity.locations.destroy'
    ]);
    $router->bind('activity', function ($id) {
        return app('Modules\Activity\Repositories\ActivityRepository')->find($id);
    });
    $router->get('activities', [
        'as' => 'admin.activity.activity.index',
        'uses' => 'ActivityController@index',
        'middleware' => 'can:activity.activities.index'
    ]);
    $router->get('activities/create', [
        'as' => 'admin.activity.activity.create',
        'uses' => 'ActivityController@create',
        'middleware' => 'can:activity.activities.create'
    ]);
    $router->post('activities', [
        'as' => 'admin.activity.activity.store',
        'uses' => 'ActivityController@store',
        'middleware' => 'can:activity.activities.create'
    ]);
    $router->get('activities/{activity}/edit', [
        'as' => 'admin.activity.activity.edit',
        'uses' => 'ActivityController@edit',
        'middleware' => 'can:activity.activities.edit'
    ]);
    $router->put('activities/{activity}', [
        'as' => 'admin.activity.activity.update',
        'uses' => 'ActivityController@update',
        'middleware' => 'can:activity.activities.edit'
    ]);
    $router->delete('activities/{activity}', [
        'as' => 'admin.activity.activity.destroy',
        'uses' => 'ActivityController@destroy',
        'middleware' => 'can:activity.activities.destroy'
    ]);
// append



});
