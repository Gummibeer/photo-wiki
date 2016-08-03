<?php

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventAttendeesTable extends Migration
{
    public function up()
    {
        Schema::create(Event::getTableName('attendees'), function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on(User::getTableName());
            $table->integer('event_id')->unsigned();
            $table
                ->foreign('event_id')
                ->references('id')
                ->on(Event::getTableName());
        });
    }

    public function down()
    {
        Schema::dropIfExists(Event::getTableName('attendees'));
    }
}
