<?php  namespace Modules\Activity\Presenters;

use Modules\Core\Presenters\BasePresenter;

class CategoryPresenter extends BasePresenter
{
    protected $zone     = 'activityCategoryImage';
    protected $slug     = 'slug';
    protected $transKey = 'activity::routes.category.view';
    protected $routeKey = 'activity.category';
}