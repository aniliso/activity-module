<?php

namespace Modules\Activity\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'slug', 'meta_title', 'meta_description'];
    protected $table = 'activity__category_translations';
}
