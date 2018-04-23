<?php

namespace Modules\Activity\Events\Activity;

use Modules\Activity\Entities\Activity;
use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;

class ActivityIsUpdating extends AbstractEntityHook implements EntityIsChanging
{
    private $activity;

    public function __construct(Activity $activity, array $attributes)
    {
        $this->activity = $activity;
        parent::__construct($attributes);
    }

    public function getCategory()
    {
        return $this->activity;
    }
}