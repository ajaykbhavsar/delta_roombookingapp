<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemLog;

class LogController extends Controller
{
    public function index()
    {
        $logs = SystemLog::with('performedBy')->latest()->paginate(25);

        return view('admin.logs.index', compact('logs'));
    }
}

