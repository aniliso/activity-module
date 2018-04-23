<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTicketUrlColumnToActivityEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity__activity_events', function (Blueprint $table) {
            $table->string('ticket_url')->nullable();
        });
        Schema::table('activity__activities', function (Blueprint $table) {
            $activities = \Modules\Activity\Entities\Activity::all();
            foreach ($activities as $activity) {
                foreach ($activity->events as $event) {
                    $event->ticket_url = $activity->ticket_url;
                    $event->save();
                }
            }
            $table->dropColumn('ticket_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity__activities', function (Blueprint $table) {
            $table->string('ticket_url')->nullable();
        });
        Schema::table('activity__activity_events', function (Blueprint $table) {
            $activities = \Modules\Activity\Entities\Activity::all();
            foreach ($activities as $activity) {
                $activity->ticket_url = $activity->events()->first()->ticket_url;
            }
            $table->dropColumn('ticket_url');
        });
    }
}
