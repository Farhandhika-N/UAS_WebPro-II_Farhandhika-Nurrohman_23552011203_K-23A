<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('aktivitas', 'like', '%' . $request->search . '%')
                  ->orWhere('modul', 'like', '%' . $request->search . '%')
                  ->orWhere('aksi', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($user) use ($request) {
                        $user->where('name', 'like', '%' . $request->search . '%');
                  });

            });

        }

        $logs = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('activity-log.index', compact('logs'));
    }
}