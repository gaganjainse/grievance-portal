<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grievance;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class GrievanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Grievance::with(['user', 'department', 'category', 'assignedOfficer']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('ticket_id', 'like', "%{$s}%")
                  ->orWhere('subject', 'like', "%{$s}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $grievances = $query->latest()->paginate(20);
        $departments = Department::where('is_active', true)->get();
        $statuses = ['pending', 'under_review', 'in_progress', 'resolved', 'rejected', 'closed'];

        return view('admin.grievances.index', compact('grievances', 'departments', 'statuses'));
    }

    public function show(Grievance $grievance)
    {
        $grievance->load(['user', 'department', 'category', 'assignedOfficer', 'comments.user', 'attachments']);
        $officers = User::where('role', 'officer')
            ->where(function ($q) use ($grievance) {
                $q->where('department_id', $grievance->department_id)
                  ->orWhereNull('department_id');
            })
            ->where('is_active', true)
            ->get();

        return view('admin.grievances.show', compact('grievance', 'officers'));
    }

    public function assign(Request $request, Grievance $grievance)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $grievance->update([
            'assigned_to' => $validated['assigned_to'],
            'status' => 'under_review',
            'assigned_at' => now(),
        ]);

        return back()->with('success', 'Grievance assigned successfully.');
    }

    public function updateStatus(Request $request, Grievance $grievance)
    {
        $validated = $request->validate([
            'status' => 'required|in:under_review,in_progress,resolved,rejected,closed',
            'resolution_notes' => 'required_if:status,resolved,rejected|nullable|string',
        ]);

        $data = ['status' => $validated['status']];

        if (in_array($validated['status'], ['resolved', 'rejected'])) {
            $data['resolved_at'] = now();
            $data['resolution_notes'] = $validated['resolution_notes'];
        }

        if ($validated['status'] === 'in_progress' && !$grievance->assigned_at) {
            $data['assigned_at'] = now();
        }

        $grievance->update($data);

        return back()->with('success', 'Grievance status updated successfully.');
    }
}
