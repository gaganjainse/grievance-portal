<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Grievance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'assigned' => Grievance::where('assigned_to', $user->id)->count(),
            'in_progress' => Grievance::where('assigned_to', $user->id)
                ->where('status', 'in_progress')->count(),
            'resolved' => Grievance::where('assigned_to', $user->id)
                ->whereIn('status', ['resolved', 'closed'])->count(),
            'pending_review' => Grievance::where('assigned_to', $user->id)
                ->where('status', 'under_review')->count(),
        ];

        $myGrievances = Grievance::where('assigned_to', $user->id)
            ->with(['user', 'department', 'category'])
            ->latest()
            ->take(10)
            ->get();

        $departmentGrievances = Grievance::where('department_id', $user->department_id)
            ->whereNull('assigned_to')
            ->with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

        return view('officer.dashboard', compact(
            'stats', 'myGrievances', 'departmentGrievances'
        ));
    }
}
