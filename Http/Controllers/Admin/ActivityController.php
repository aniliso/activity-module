<?php

namespace Modules\Activity\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Activity\Entities\Activity;
use Modules\Activity\Entities\Event;
use Modules\Activity\Http\Requests\CreateActivityRequest;
use Modules\Activity\Http\Requests\UpdateActivityRequest;
use Modules\Activity\Repositories\ActivityRepository;
use Modules\Activity\Repositories\CategoryRepository;
use Modules\Activity\Repositories\LocationRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Carbon\Carbon;

class ActivityController extends AdminBaseController
{
    /**
     * @var ActivityRepository
     */
    private $activity;
    /**
     * @var CategoryRepository
     */
    private $category;
    /**
     * @var LocationRepository
     */
    private $location;

    public function __construct(ActivityRepository $activity, CategoryRepository $category, LocationRepository $location)
    {
        parent::__construct();

        $this->activity = $activity;
        $this->category = $category;
        $this->location = $location;

        view()->share('categoryLists', $this->category->all()->pluck('title', 'id')->toArray());
        view()->share('locationLists', $this->location->all()->pluck('title', 'id')->toArray());
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $activities = $this->activity->all();

        return view('activity::admin.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('activity::admin.activities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateActivityRequest $request
     * @return Response
     */
    public function store(CreateActivityRequest $request)
    {
        $model = $this->activity->create($request->all());

        if ($request->has('events') && is_array($request->get('events'))) {
            foreach($request->get('events') as $event) {
                $new_event = new Event([
                    'activity_id' => $model->id,
                    'location_id' => $event['location_id'],
                    'event_at'    => Carbon::parse($event['event_at']),
                    'ticket_url'  => $event['ticket_url']
                ]);
                $model->events()->save($new_event);
            }
        }

        return redirect()->route('admin.activity.activity.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('activity::activities.title.activities')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Activity $activity
     * @return Response
     */
    public function edit(Activity $activity)
    {
        return view('activity::admin.activities.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Activity $activity
     * @param  UpdateActivityRequest $request
     * @return Response
     */
    public function update(Activity $activity, UpdateActivityRequest $request)
    {
        $model = $this->activity->update($activity, $request->all());

        if ($request->has('events') && is_array($request->get('events'))) {
            foreach ($request->get('events') as $event) {
                $new_event = $model->events()->findOrNew($event['event_id']);
                $new_event->activity_id  = $model->id;
                $new_event->location_id  = $event['location_id'];
                $new_event->event_at     = Carbon::parse($event['event_at']);
                $new_event->ticket_url   = $event['ticket_url'];
                $new_event->save();
            }
            $check_events = array_column($request->get('events'), 'event_id');
            $model->events()->whereNotIn('id', $check_events)->delete();
        }

        return redirect()->route('admin.activity.activity.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('activity::activities.title.activities')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Activity $activity
     * @return Response
     */
    public function destroy(Activity $activity)
    {
        $this->activity->destroy($activity);

        return redirect()->route('admin.activity.activity.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('activity::activities.title.activities')]));
    }
}