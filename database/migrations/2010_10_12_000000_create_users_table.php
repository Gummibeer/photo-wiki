<?php

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create(User::getTableName(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('nickname')->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists(User::getTableName());
    }
}