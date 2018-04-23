<?php

namespace Modules\Activity\Events\Activity;

use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;

class ActivityIsCreating extends AbstractEntityHook implements EntityIsChanging
{

}