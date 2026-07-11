<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['grievance_id', 'user_id', 'body'];

    public function grievance()
    {
        return $this->belongsTo(Grievance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
