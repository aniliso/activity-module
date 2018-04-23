<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity__locations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->string('county');
            $table->string('city');

            $table->timestamps();
        });

        Schema::create('activity__location_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->string('title');

            $table->integer('location_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['location_id', 'locale']);
            $table->foreign('location_id')->references('id')->on('activity__locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity__location_translations', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
        });
        Schema::dropIfExists('activity__location_translations');
        Schema::dropIfExists('activity__locations');
    }
}
