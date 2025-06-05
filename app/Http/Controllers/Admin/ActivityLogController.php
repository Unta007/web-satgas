<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activityLogs = Activity::with('causer')
            ->latest()
            ->get(); 
        return view('admin.logs.index', compact('activityLogs'));
    }
}
