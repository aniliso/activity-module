<?php

namespace Modules\Activity\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ActivityRepository extends BaseRepository
{
    public function latest($amount=10);
    public function getPreviousOf($activity);
    public function getNextOf($activity);
}
