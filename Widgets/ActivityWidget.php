<?php namespace Modules\Activity\Widgets;


use Modules\Activity\Repositories\ActivityRepository;
use Modules\Activity\Repositories\EventRepository;

class ActivityWidget
{
    /**
     * @var ActivityRepository
     */
    private $activity;
    /**
     * @var EventRepository
     */
    private $event;

    public function __construct(ActivityRepository $activity, EventRepository $event)
    {
        $this->activity = $activity;
        $this->event = $event;
    }

    public function latest($amount=10, $view='latest')
    {
        $activities = $this->activity->latest($amount);
        return view('activity::widgets.'.$view, compact('activities'));
    }

    public function events()
    {
        $activities = $this->activity->latest(0);
        return view('activity::widgets.events-calendar', compact('activities'));
    }
}