<?php namespace Modules\Activity\Widgets;


use Modules\Activity\Repositories\EventRepository;

class EventWidget
{
    /**
     * @var EventRepository
     */
    private $event;

    /**
     * EventWidget constructor.
     * @param EventRepository $event
     */
    public function __construct(EventRepository $event)
    {
        $this->event = $event;
    }

    public function latest($amount=10)
    {
        $events = $this->event->latest(12);
        return view('activity::widgets.latest-events', compact('events'));
    }
}