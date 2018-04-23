<?php namespace Modules\Activity\Presenters;

use Modules\Core\Presenters\BasePresenter;

class EventPresenter extends BasePresenter
{
    public function start_at($format='%d %B %Y')
    {
        return $this->entity->pivot->start_at->formatLocalized($format);
    }

    public function days()
    {
        return collect(date_range($this->entity->start_at, $this->entity->end_at));
    }
}