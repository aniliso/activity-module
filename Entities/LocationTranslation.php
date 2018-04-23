<?php

namespace Modules\Activity\Entities;

use Illuminate\Database\Eloquent\Model;

class LocationTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'activity__location_translations';
    protected $fillable = ['title'];
}
