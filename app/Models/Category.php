<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'department_id',
        'description', 'escalation_days', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'escalation_days' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function grievances()
    {
        return $this->hasMany(Grievance::class);
    }
}
