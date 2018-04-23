<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' =>''], function (Router $router) {
    $router->get(LaravelLocalization::transRoute('activity::routes.category.view'), [
        'as'         => 'activity.category',
        'uses'       => 'ActivityController@category'
    ]);
    $router->get(LaravelLocalization::transRoute('activity::routes.activity.index'), [
        'as'         => 'activity.index',
        'uses'       => 'ActivityController@index'
    ]);
    $router->get(LaravelLocalization::transRoute('activity::routes.activity.view'), [
        'as'         => 'activity.view',
        'uses'       => 'ActivityController@view'
    ]);
});