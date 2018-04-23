<?php

namespace Modules\Activity\Entities;

use Illuminate\Database\Eloquent\Model;

class ActivityTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'slug', 'description', 'meta_title', 'meta_description'];
    protected $table = 'activity__activity_translations';
}
