<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SystemLogger
{
    /**
     * Log a system event to the database.
     *
     * @param string $event
     * @param string $description
     * @param int|null $userId
     * @return void
     */
    public static function log($event, $description, $userId = null)
    {
        ActivityLog::create([
            'user_id' => $userId ?? Auth::id(),
            'event' => $event,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
