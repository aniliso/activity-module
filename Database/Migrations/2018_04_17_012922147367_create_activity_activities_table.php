<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity__activities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->tinyInteger('status')->default(1);
            $table->integer('sorting')->default(1);

            $table->string('ticket_url')->nullable();
            $table->string('video_url')->nullable();
            $table->text('settings')->nullable();

            // Meta Settings
            $table->boolean('sitemap_include')->default(1);
            $table->enum('sitemap_priority', ['0.0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1.0'])->default('0.9');
            $table->enum('sitemap_frequency', ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'])->default('weekly');

            // Relations
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('activity__categories')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('activity__activity_events', function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->dateTime('event_at');

            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('activity__activities')->onDelete('cascade');

            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('activity__locations')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity__events');
        Schema::dropIfExists('activity__activity_events');
        Schema::dropIfExists('activity__activities');
    }
}
