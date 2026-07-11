<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Grievance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total' => Grievance::where('user_id', $user->id)->count(),
            'pending' => Grievance::where('user_id', $user->id)->where('status', 'pending')->count(),
            'in_progress' => Grievance::where('user_id', $user->id)
                ->whereIn('status', ['under_review', 'in_progress'])->count(),
            'resolved' => Grievance::where('user_id', $user->id)
                ->whereIn('status', ['resolved', 'closed'])->count(),
        ];

        $recentGrievances = Grievance::where('user_id', $user->id)
            ->with(['department', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('citizen.dashboard', compact('stats', 'recentGrievances'));
    }
}
