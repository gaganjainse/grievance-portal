<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'grievance_id', 'original_name', 'stored_path', 'mime_type', 'file_size',
    ];

    public function grievance()
    {
        return $this->belongsTo(Grievance::class);
    }
}
