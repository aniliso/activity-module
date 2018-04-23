<?php namespace Modules\Activity\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface EventRepository extends BaseRepository
{
    public function latest($amount=10);
}