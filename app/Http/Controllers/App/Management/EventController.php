<?php

namespace App\Http\Controllers\App\Management;

use App\DataTables\EventDataTable;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->authorize('manage', Event::class);
    }

    public function getIndex(EventDataTable $dataTable)
    {
        return $dataTable->render('app.management.event.index');
    }

    public function getApprove(Request $request, Event $event)
    {
        $this->authorize('approve', $event);

        $event->approve();

        return redirect()->back();
    }

    public function getDelete(Request $request, Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->back();
    }
}
