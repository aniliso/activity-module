<?php

namespace Modules\Activity\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Activity\Presenters\CategoryPresenter;

class Category extends Model
{
    use Translatable, PresentableTrait;

    protected $table = 'activity__categories';
    public $translatedAttributes = ['title', 'slug', 'meta_title', 'meta_description'];
    protected $fillable = ['title', 'slug', 'meta_title', 'meta_description', 'status', 'sorting'];

    protected $presenter = CategoryPresenter::class;

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function getUrlAttribute()
    {
        return route('activity.category', $this->slug);
    }
}
