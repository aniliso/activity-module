<?php namespace Modules\Activity\Repositories\Eloquent;

use Modules\Activity\Repositories\EventRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentEventRepository extends EloquentBaseRepository implements EventRepository
{
    public function latest($amount = 10)
    {
        return $this->model->get();
    }
}