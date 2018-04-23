<?php  namespace Modules\Activity\Presenters;

use Modules\Core\Presenters\BasePresenter;

class ActivityPresenter extends BasePresenter
{
    protected $zone     = 'activityImage';
    protected $slug     = 'slug';
    protected $transKey = 'activity::routes.activity.view';
    protected $routeKey = 'activity.view';

    public function coverImage($width, $height, $mode, $quality)
    {
        if($file = $this->entity->filesByZone('activityCoverImage')->first()) {
            return \Imagy::getImage($file->filename, $this->zone, ['width' => $width, 'height' => $height, 'mode' => $mode, 'quality' => $quality]);
        }
        return false;
    }
}