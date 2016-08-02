<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getShow()
    {
        return view('app.dashboard.show');
    }
}
