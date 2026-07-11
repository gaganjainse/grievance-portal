<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Grievance;
use App\Models\Comment;
use Illuminate\Http\Request;

class GrievanceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Grievance::where('department_id', $user->department_id)
            ->with(['user', 'category']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('subject', 'like', "%{$s}%")
                  ->orWhere('ticket_id', 'like', "%{$s}%");
            });
        }

        $grievances = $query->latest()->paginate(20);

        return view('officer.index', compact('grievances'));
    }

    public function show(Grievance $grievance)
    {
        $user = auth()->user();
        if ($grievance->department_id !== $user->department_id && !$user->isAdmin()) {
            abort(403);
        }

        $grievance->load(['user', 'department', 'category', 'assignedOfficer', 'comments.user', 'attachments']);
        return view('officer.show', compact('grievance'));
    }

    public function assignToMe(Grievance $grievance)
    {
        $user = auth()->user();
        if ($grievance->department_id !== $user->department_id) {
            abort(403);
        }

        $grievance->update([
            'assigned_to' => $user->id,
            'status' => 'under_review',
            'assigned_at' => now(),
        ]);

        return back()->with('success', 'Grievance assigned to you.');
    }

    public function updateStatus(Request $request, Grievance $grievance)
    {
        $user = auth()->user();
        if ($grievance->department_id !== $user->department_id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:in_progress,resolved,rejected,closed',
            'resolution_notes' => 'required_if:status,resolved,rejected|nullable|string',
        ]);

        $data = ['status' => $validated['status']];

        if (in_array($validated['status'], ['resolved', 'rejected'])) {
            $data['resolved_at'] = now();
            $data['resolution_notes'] = $validated['resolution_notes'];
        }

        if (!$grievance->assigned_to) {
            $data['assigned_to'] = $user->id;
            $data['assigned_at'] = now();
        }

        if ($validated['status'] === 'in_progress' && !$grievance->assigned_at) {
            $data['assigned_at'] = now();
        }

        $grievance->update($data);

        return back()->with('success', 'Grievance status updated.');
    }

    public function addComment(Request $request, Grievance $grievance)
    {
        $user = auth()->user();
        if ($grievance->department_id !== $user->department_id) {
            abort(403);
        }

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        Comment::create([
            'grievance_id' => $grievance->id,
            'user_id' => $user->id,
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Comment added.');
    }
}
