<?php

namespace Modules\Activity\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Activity\Presenters\ActivityPresenter;
use Modules\Media\Support\Traits\MediaRelation;

class Activity extends Model
{
    use Translatable, PresentableTrait, MediaRelation;

    protected $table = 'activity__activities';
    public $translatedAttributes = ['title', 'slug', 'description', 'meta_title', 'meta_description'];
    protected $fillable = ['category_id', 'title', 'slug', 'description', 'meta_title', 'meta_description', 'ticket_url', 'video_url','settings', 'status', 'sorting', 'sitemap_include','sitemap_priority', 'sitemap_frequency'];

    protected $presenter = ActivityPresenter::class;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class)->orderBy('event_at', 'asc');
    }

    public function getUrlAttribute()
    {
        return route('activity.view', [$this->slug]);
    }

    public function scopeOrderByEvents($query)
    {
        $activity_tb = $this->table;
        $event_tb = Event::getModel()->getTable();

        return $query->select("$activity_tb.*")
                     ->leftJoin("$event_tb", "$activity_tb.id", '=', "$event_tb.activity_id")
                     ->orderBy("$event_tb.event_at", 'asc')
                     ->groupBy("$activity_tb.id");
    }

    public function scopeActivated($query)
    {
        return $query->whereStatus(1);
    }
}
