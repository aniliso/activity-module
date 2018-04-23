<?php

namespace Modules\Activity\Repositories\Cache;

use Modules\Activity\Repositories\CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoryDecorator extends BaseCacheDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'activity.categories';
        $this->repository = $category;
    }
}
