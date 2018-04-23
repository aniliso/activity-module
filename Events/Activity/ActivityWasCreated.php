<?php

namespace Modules\Activity\Events\Activity;

use Modules\Activity\Entities\Activity;
use Modules\Media\Contracts\StoringMedia;

class ActivityWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var Activity
     */
    public $activity;

    public function __construct($activity, array $data)
    {
        $this->data = $data;
        $this->activity = $activity;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->activity;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
