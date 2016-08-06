<?php

use Fenos\Notifynder\Models\NotificationCategory;
use Illuminate\Database\Migrations\Migration;

class AddEventApproveRequiredNotification extends Migration
{
    public function up()
    {
        NotificationCategory::create([
            'name' => 'event.approve.required',
            'text' => 'event.approve.required',
        ]);
    }

    public function down()
    {
        //
    }
}
