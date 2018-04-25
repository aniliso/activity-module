<?php

namespace Modules\Activity\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Activity\Events\Activity\ActivityIsUpdating;
use Modules\Activity\Events\Activity\ActivityWasCreated;
use Modules\Activity\Repositories\ActivityRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Activity\Events\Activity\ActivityIsCreating;
use Modules\Activity\Events\Activity\ActivityWasUpdated;

class EloquentActivityRepository extends EloquentBaseRepository implements ActivityRepository
{
    public function create($data)
    {
        event($event = new ActivityIsCreating($data));

        $model = $this->model->create($event->getAttributes());

        event(new ActivityWasCreated($model, $data));

        return $model;
    }

    public function update($model, $data)
    {
        event($event = new ActivityIsUpdating($model, $data));

        $model->update($event->getAttributes());

        event(new ActivityWasUpdated($model, $data));

        return $model;
    }

    /**
     * Get the previous post of the given post
     * @param object $activity
     * @return object
     */
    public function getPreviousOf($activity)
    {
        return $this->model->where('created_at', '<', $activity->created_at)
            ->whereStatus(1)->orderBy('created_at', 'desc')->first();
    }

    /**
     * Get the next post of the given post
     * @param object $activity
     * @return object
     */
    public function getNextOf($activity)
    {
        return $this->model->where('created_at', '>', $activity->created_at)
            ->whereStatus(1)->first();
    }

    public function latest($amount = 10)
    {
        $activity = $this->model->orderByEvents()->activated();

        if($amount != 0 && is_integer($amount)) {
            return $activity->take($amount)->get();
        }

        return $activity->withTransRelated()->activated()->get();
    }

    public function paginate($perPage = 15)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->withTransRelated()
                ->orderByEvents()
                ->activated()
                ->paginate($perPage);
        }

        return $this->model->withRelated()
            ->orderByEvents()
            ->activated()
            ->paginate($perPage);
    }

    public function findBySlug($slug)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->whereHas('translations', function (Builder $q) use ($slug) {
                $q->where('slug', $slug);
            })->whereHas('events', function(Builder $q){
                $q->activated();
            })->withTransRelated()->first();
        }

        return $this->model->where('slug', $slug)->withRelated()->activated()->first();
    }


}
