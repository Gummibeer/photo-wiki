<?php

use App\Models\Event;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create(Event::getTableName(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('display_name');
            $table->timestamp('starting_at');
            $table->timestamp('ending_at');
            $table->string('timezone');
            $table->boolean('all_day');
            $table->text('location')->nullable();
            $table->text('geoloc')->nullable();
            $table->text('description')->nullable();
            $table->boolean('approved')->default(false);
            $table->string('google_calendar_id')->nullable();
            $table->string('google_event_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Event::getTableName());
    }
}