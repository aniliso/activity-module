<?php

namespace Modules\Activity\Repositories\Cache;

use Modules\Activity\Repositories\LocationRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheLocationDecorator extends BaseCacheDecorator implements LocationRepository
{
    public function __construct(LocationRepository $location)
    {
        parent::__construct();
        $this->entityName = 'activity.locations';
        $this->repository = $location;
    }
}
