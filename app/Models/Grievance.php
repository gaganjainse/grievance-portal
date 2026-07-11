<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grievance extends Model
{
    protected $fillable = [
        'ticket_id', 'user_id', 'department_id', 'category_id',
        'assigned_to', 'subject', 'description', 'location', 'pincode',
        'priority', 'status', 'submitted_at', 'assigned_at',
        'resolved_at', 'resolution_notes',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'assigned_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function assignedOfficer()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function isOverdue(): bool
    {
        if ($this->status === 'resolved' || $this->status === 'closed' || $this->status === 'rejected') {
            return false;
        }
        $deadline = $this->submitted_at->addDays($this->category->escalation_days);
        return now()->gt($deadline);
    }

    public static function generateTicketId(): string
    {
        $prefix = 'GRV';
        $date = now()->format('Ymd');
        $last = self::whereDate('created_at', today())->count();
        return $prefix . $date . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }
}
