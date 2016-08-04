<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getReadNotifications(Request $request, $notificationId = null)
    {
        if (empty($notificationId)) {
            \Auth::User()->readAllNotifications();
        } else {
            $notification = \Auth::user()->notifications()->findOrFail($notificationId);
            $notification->read = 1;
            $notification->save();
            if (! empty($notification->url)) {
                if (is_json($notification->url)) {
                    $json = json_decode($notification->url);
                    $route = array_shift($json);

                    return redirect()->route($route, $json);
                } else {
                    return redirect()->to($notification->url);
                }
            }
        }

        return back();
    }
}
