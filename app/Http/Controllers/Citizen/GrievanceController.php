<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Grievance;
use App\Models\Department;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GrievanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Grievance::where('user_id', auth()->id())
            ->with(['department', 'category']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('subject', 'like', "%{$s}%")
                  ->orWhere('ticket_id', 'like', "%{$s}%");
            });
        }

        $grievances = $query->latest()->paginate(10);

        return view('citizen.index', compact('grievances'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('citizen.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'category_id' => 'required|exists:categories,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|size:6',
            'priority' => 'required|in:low,medium,high,urgent',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['ticket_id'] = Grievance::generateTicketId();
        $validated['submitted_at'] = now();
        $validated['status'] = 'pending';

        $grievance = Grievance::create($validated);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments/' . $grievance->id, 'public');
                $grievance->attachments()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'stored_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('citizen.grievances.show', $grievance)
            ->with('success', 'Grievance submitted successfully. Your Ticket ID: ' . $grievance->ticket_id);
    }

    public function show(Grievance $grievance)
    {
        if ($grievance->user_id !== auth()->id()) {
            abort(403);
        }
        $grievance->load(['department', 'category', 'assignedOfficer', 'comments.user', 'attachments']);
        return view('citizen.show', compact('grievance'));
    }

    public function addComment(Request $request, Grievance $grievance)
    {
        if ($grievance->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        Comment::create([
            'grievance_id' => $grievance->id,
            'user_id' => auth()->id(),
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Comment added successfully.');
    }
}
