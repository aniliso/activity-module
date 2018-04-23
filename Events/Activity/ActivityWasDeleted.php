<?php

namespace Modules\Activity\Events\Activity;

use Modules\Media\Contracts\DeletingMedia;

class ActivityWasDeleted implements DeletingMedia
{
    /**
     * @var string
     */
    private $activityClass;
    /**
     * @var int
     */
    private $activityId;

    public function __construct($activityId, $activityClass)
    {
        $this->activityClass = $activityClass;
        $this->activityId = $activityId;
    }

    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->activityId;
    }

    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return $this->activityClass;
    }
}
