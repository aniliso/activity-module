<?php

namespace Modules\Activity\Http\Controllers;

use Illuminate\Http\Response;
use Modules\Activity\Repositories\ActivityRepository;
use Modules\Activity\Repositories\CategoryRepository;
use Modules\Core\Http\Controllers\BasePublicController;
use Breadcrumbs;

class ActivityController extends BasePublicController
{
    /**
     * @var ActivityRepository
     */
    private $activity;
    /**
     * @var CategoryRepository
     */
    private $category;

    private $per_page = 6;

    /**
     * ActivityController constructor.
     * @param ActivityRepository $activity
     */
    public function __construct(ActivityRepository $activity, CategoryRepository $category)
    {
        parent::__construct();
        $this->activity = $activity;
        $this->category = $category;

        /* Start Default Breadcrumbs */
        if(!app()->runningInConsole()) {
            Breadcrumbs::register('activity.index', function ($breadcrumbs) {
                $breadcrumbs->push(trans('themes::activity.title.activities'), route('activity.index'));
            });
        }
        /* End Default Breadcrumbs */
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $activities = $this->activity->paginate($this->per_page);

        $this->seo()->setTitle(trans('themes::activity.meta.title'))
             ->setDescription(trans('themes::activity.meta.description'));

        return view('activity::index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function view($slug="")
    {
        $activity = $this->activity->findBySlug($slug);
        if(!$activity) abort(404);

        $this->seo()->setTitle($activity->title)
            ->setDescription($activity->meta_description)
            ->meta()
            ->setUrl($activity->url)
            ->addAlternates($activity->present()->languages);

        $this->seoGraph()
            ->setTitle($activity->title)
            ->setDescription($activity->meta_description)
            ->setImage($activity->present()->og_image)
            ->setUrl($activity->url);

        /* Start Breadcrumbs */
        Breadcrumbs::register('activity.view', function($breadcrumbs) use ($activity) {
            $breadcrumbs->parent('activity.index');
            if(isset($activity->category)) $breadcrumbs->push($activity->category->title, $activity->category->url);
            $breadcrumbs->push($activity->title, $activity->url);
        });
        /* End Breadcrumbs */

        return view('activity::view', compact('activity'));
    }

    public function category($slug="")
    {
        $category = $this->category->findBySlug($slug);

        if(is_null($category)) abort(404);

        $activities = $category->activities()
                            ->orderByEvents()
                            ->activated()
                            ->paginate($this->per_page);

        $this->seo()->setTitle($category->title)
            ->setDescription($category->title)
            ->meta()
            ->setUrl($category->url)
            ->addAlternates($category->present()->languages);

        /* Start Breadcrumbs */
        Breadcrumbs::register('activity.category', function($breadcrumbs) use ($category) {
            $breadcrumbs->parent('activity.index');
            $breadcrumbs->push($category->title, $category->url);
        });
        /* End Breadcrumbs */

        return view('activity::category', compact('category', 'activities'));
    }
}
