<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemLog;

class LogController extends Controller
{
    public function index()
    {
        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized');
        }
        $logs = SystemLog::with('performedBy')->latest()->paginate(25);

        return view('admin.logs.index', compact('logs'));
    }
}





