<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grievance;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_grievances' => Grievance::count(),
            'pending' => Grievance::where('status', 'pending')->count(),
            'in_progress' => Grievance::where('status', 'in_progress')->count(),
            'resolved' => Grievance::where('status', 'resolved')->count(),
            'total_users' => User::count(),
            'total_citizens' => User::where('role', 'citizen')->count(),
            'total_officers' => User::where('role', 'officer')->count(),
            'total_departments' => Department::count(),
        ];

        $recentGrievances = Grievance::with(['user', 'department', 'category'])
            ->latest()
            ->take(10)
            ->get();

        $departmentStats = Department::withCount('grievances')
            ->get()
            ->map(fn($d) => [
                'name' => $d->name,
                'total' => $d->grievances_count,
                'resolved' => Grievance::where('department_id', $d->id)
                    ->whereIn('status', ['resolved', 'closed'])
                    ->count(),
            ]);

        $monthlyData = Grievance::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->take(12)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'recentGrievances', 'departmentStats', 'monthlyData'
        ));
    }
}
