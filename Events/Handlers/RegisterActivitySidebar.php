<?php

namespace Modules\Activity\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Sidebar\AbstractAdminSidebar;

class RegisterActivitySidebar extends AbstractAdminSidebar
{
    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('activity::activities.title.activities'), function (Item $item) {
                $item->icon('fa fa-star');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('activity::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-th');
                    $item->weight(0);
                    $item->append('admin.activity.category.create');
                    $item->route('admin.activity.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('activity.categories.index')
                    );
                });
                $item->item(trans('activity::locations.title.locations'), function (Item $item) {
                    $item->icon('fa fa-map-marker');
                    $item->weight(0);
                    $item->append('admin.activity.location.create');
                    $item->route('admin.activity.location.index');
                    $item->authorize(
                        $this->auth->hasAccess('activity.locations.index')
                    );
                });
                $item->item(trans('activity::activities.title.activity'), function (Item $item) {
                    $item->icon('fa fa-calendar');
                    $item->weight(0);
                    $item->append('admin.activity.activity.create');
                    $item->route('admin.activity.activity.index');
                    $item->authorize(
                        $this->auth->hasAccess('activity.activities.index')
                    );
                });
// append



            });
        });

        return $menu;
    }
}
