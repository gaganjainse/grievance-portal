<?php

use Illuminate\Support\Facades\Schedule;

// Escalate overdue grievances daily
Schedule::call(function () {
    \App\Models\Grievance::whereNotIn('status', ['resolved', 'closed', 'rejected'])
        ->where('created_at', '<', now()->subDays(7))
        ->update(['priority' => 'urgent']);
})->daily();
