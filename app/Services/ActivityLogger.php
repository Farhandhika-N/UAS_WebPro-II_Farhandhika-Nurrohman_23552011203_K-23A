<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log($aktivitas, $modul, $aksi)
    {
        if (!auth()->check()) {
            return;
        }

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'aktivitas'  => $aktivitas,
            'modul'      => $modul,
            'aksi'       => strtoupper($aksi),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}