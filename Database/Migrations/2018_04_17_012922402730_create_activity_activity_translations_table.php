<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityActivityTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity__activity_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your translatable fields
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->integer('activity_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['activity_id', 'locale']);
            $table->foreign('activity_id')->references('id')->on('activity__activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity__activity_translations', function (Blueprint $table) {
            $table->dropForeign(['activity_id']);
        });
        Schema::dropIfExists('activity__activity_translations');
    }
}
