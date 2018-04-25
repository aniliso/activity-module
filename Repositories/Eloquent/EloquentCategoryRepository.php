<?php

namespace Modules\Activity\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Activity\Repositories\CategoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{
    public function findBySlug($slug)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->whereHas('translations', function (Builder $q) use ($slug) {
                $q->where('slug', $slug);
            })->with(['translations','activities'])->first();
        }

        return $this->model->where('slug', $slug)->first();
    }
}
