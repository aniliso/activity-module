<?php namespace Modules\Activity\Entities;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Activity\Presenters\EventPresenter;
use Carbon\Carbon;

class Event extends Model
{
    use PresentableTrait;

    public $timestamps = true;
    protected $table = 'activity__activity_events';
    protected $fillable = ['location_id', 'activity_id','event_at','ticket_url'];

    protected $dates = [
      'event_at',
    ];

    protected $with = [
      'location',
      'activity'
    ];

    protected $presenter = EventPresenter::class;

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function scopeActivated($query)
    {
        return $query->where('event_at', '>=', Carbon::now());
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('event_at', 'ASC');
    }
}