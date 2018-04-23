<?php

namespace Modules\Activity\Repositories\Cache;

use Modules\Activity\Repositories\ActivityRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheActivityDecorator extends BaseCacheDecorator implements ActivityRepository
{
    public function __construct(ActivityRepository $activity)
    {
        parent::__construct();
        $this->entityName = 'activity.activities';
        $this->repository = $activity;
    }

    /**
     * Get the next post of the given post
     * @param object $activity
     * @return object
     */
    public function getNextOf($activity)
    {
        $activityId = $activity->id;

        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.getNextOf.{$activityId}", $this->cacheTime,
                function () use ($activity) {
                    return $this->repository->getNextOf($activity);
                }
            );
    }

    /**
     * Get the next post of the given post
     * @param object $activity
     * @return object
     */
    public function getPreviousOf($activity)
    {
        $activityId = $activity->id;

        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.getPreviousOf.{$activityId}", $this->cacheTime,
                function () use ($activity) {
                    return $this->repository->getNextOf($activity);
                }
            );
    }

    public function latest($amount = 10)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.latest.{$amount}", $this->cacheTime,
                function () use ($amount) {
                    return $this->repository->latest($amount);
                }
            );
    }
}
