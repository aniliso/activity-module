<?php

namespace Modules\Activity\Entities;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Location extends Model
{
    use Translatable;

    protected $table = 'activity__locations';
    public $translatedAttributes = ['title'];
    protected $fillable = ['title', 'county', 'city'];
}
