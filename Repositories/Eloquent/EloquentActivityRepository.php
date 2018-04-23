<?php

namespace Modules\Activity\Repositories\Eloquent;

use Modules\Activity\Entities\Activity;
use Modules\Activity\Entities\Event;
use Modules\Activity\Events\Activity\ActivityIsUpdating;
use Modules\Activity\Events\Activity\ActivityWasCreated;
use Modules\Activity\Repositories\ActivityRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Activity\Events\Activity\ActivityIsCreating;
use Modules\Activity\Events\Activity\ActivityWasUpdated;
use Carbon\Carbon;

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
//        $activity_tb = $this->model->getTable();
//        $event_tb = Event::getModel()->getTable();
//
//        $activity = $this->model->select("$activity_tb.*")
//            ->leftJoin("$event_tb", "$activity_tb.id", '=', "$event_tb.activity_id")
//            ->whereHas('events', function($query){
//            $query->activated();
//            $query->ordered();
//        })->whereStatus(1)->groupBy("$activity_tb.id")
//            ->orderBy("$event_tb.event_at", 'asc');

        $activity = $this->model->orderByEvents()->activated();

        if($amount > 0) {
            return $activity->take($amount)->get();
        }

        return $activity->get();
    }

    public function paginate($perPage = 15)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->with('translations')->orderByEvents()->activated()->paginate($perPage);
        }

        return $this->model->orderByEvents()->activated()->paginate($perPage);
    }


}
